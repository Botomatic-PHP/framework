<?php

namespace Botomatic\Engine\Facebook\Core;

class Dispatcher
{
    const ERROR_CODE_LIMIT_EXCEEDED = 100;

    /**
     * @var string
     */
    private $access_token;

    /**
     * @var array
     */
    protected $messages = [];

    /**
     * @var
     */
    protected $url;

    /**
     * Facebook constructor.
     * @param \Botomatic\Engine\Core\Entities\Session $session
     */
    public function __construct(\Botomatic\Engine\Core\Entities\Session $session)
    {
        $this->access_token = config('botomatic.facebook.pages.' . $session->getUser()->getFacebookPage());

        $this->url = 'https://graph.facebook.com/' . env('BOTOMATIC_FACEBOOK_GRAPH_VERSION', 'v2.9') . "/me/messages?access_token={$this->access_token}";
    }


    /**
     * Send signal to start typing
     *
     * @param \Botomatic\Engine\Core\Entities\Session $session
     */
    public function typingOn(\Botomatic\Engine\Core\Entities\Session $session)
    {

        /**
         * Each massage contains the recipient
         */
        $message_base = [
            'recipient' => [
                'id' => $session->getUser()->getFacebookId()
            ],
            'sender_action' => 'typing_on',
        ];

        $this->curl()->post($this->url, $message_base);

        $this->curl()->close();
    }
    /**
     * Send signal to stop typing
     */
    public function typingOff(\Botomatic\Engine\Core\Entities\Session $session)
    {
        /**
         * Each massage contains the recipient
         */
        $message_base = [
            'recipient' => [
                'id' => $session->getUser()->getFacebookId()
            ],
            'sender_action' => 'typing_off',
        ];

        $this->curl()->post($this->url, $message_base);

        $this->curl()->close();
    }

    /**
     * The response of the bot
     *
     * @param \Botomatic\Engine\Facebook\Entities\Response $response
     * @param \Botomatic\Engine\Core\Entities\Session $session
     *
     * @return bool
     */
    public function sendResponse(\Botomatic\Engine\Facebook\Entities\Response $response, \Botomatic\Engine\Core\Entities\Session $session) : bool
    {
        return $this->curlFacebook($response, $session);
    }

    /**
     * Compose the base of the response
     *
     * @param \Botomatic\Engine\Facebook\Entities\Response $response
     * @param \Botomatic\Engine\Core\Entities\Session $session
     *
     * @return array
     */
    protected function build_base_message(\Botomatic\Engine\Facebook\Entities\Response $response, \Botomatic\Engine\Core\Entities\Session $session)
    {
        return [
            'recipient' => [
                'id' => $session->getUser()->getFacebookId()
            ],
        ];
    }

    /**
     * @param \Botomatic\Engine\Facebook\Entities\Response $response
     * @param \Botomatic\Engine\Core\Entities\Session $session
     *
     * @return bool
     */
    protected function curlFacebook(\Botomatic\Engine\Facebook\Entities\Response $response, \Botomatic\Engine\Core\Entities\Session $session)
    {
        /**
         * Compose messages
         */
        $messages = $this->composeResponse($response);

        if (count($messages) == 0)
        {
            $this->typingOff($session);

            return true;
        }


        /**
         * Each massage contains the recipient
         */
        $message_base = $this->build_base_message($response, $session);

//        var_dump($messages);

        foreach ($messages as $key => $message)
        {
            /**
             * Wait a few seconds?
             */
            if (isset($message['delay']))
            {
                $this->typingOn($session);

                sleep($message['delay']);

                // remove the delay
                unset($messages[$key]);

                // continue to the next item
                continue;
            }

            /**
             * Merge message with based content
             */
            $message = array_merge($message_base, $message);

            /**
             * Attempt
             */
            $this->curl()->post($this->url, $message);

            /**
             * If there was a problem with the request we continue trying to send the other messages
             */
            if ($this->curl()->error)
            {
                logger()->debug('Webhook response: ' . json_encode($this->curl()->response));

                $this->process_error($this->curl(), $message);
            }
        }

        /**
         * If we composed new messages because of errors
         */
//        foreach ($this->retry_messages as $message)
//        {
//
//        }

        $this->curl()->close();

        return true;
    }

    /**
     * @param \Botomatic\Engine\Facebook\Entities\Response $response
     *
     * @return array
     */
    public function composeResponse(\Botomatic\Engine\Facebook\Entities\Response $response) : array
    {
        $responses_entities = [];

        foreach ($response->getResponses() as $response_data)
        {
            /*
             * Delay
             */
            if ($response_data['type'] == 'delay')
            {
                $responses_entities[] = [
                    'delay' => $response_data['data']
                ];
            }

            if ($response_data['type'] == 'image')
            {
                $responses_entities[] = [
                    'message' => [
                        'attachment' => [
                            'type' => 'image',
                            'payload' => [
                                'url' => $response_data['data']
                            ]
                        ]
                    ]
                ];
            }

            if ($response_data['type'] == 'text')
            {
                /**
                 * If the message is longer than 640
                 */
                if (strlen($response_data['data']) > 640)
                {
                    $messages = str_split($response_data['data'], 640);

                    foreach ($messages as $message)
                    {
                        $responses_entities[] = [
                            'message' => [
                                'text' => $message,
                            ]
                        ];
                    }
                }
                else
                {
                    $responses_entities[] = [
                        'message' => [
                            'text' => $response_data['data'],
                        ]
                    ];
                }
            }

            if ($response_data['type'] == 'button_template')
            {
                /** @var \Botomatic\Engine\Facebook\Abstracts\States\Response\Templates\Button $button */
                $button = $response_data['data'];

                $responses_entities[] = [
                    'message' => [
                        'attachment' => [
                            'type' => 'template',
                            'payload' => [
                                'template_type' => 'button',
                                'text' => $button->title,
                                'buttons' => $button->buttons
                            ]
                        ],
                    ]
                ];
            }

            if ($response_data['type'] == 'quick_replies')
            {
                /** @var \Botomatic\Engine\Facebook\Abstracts\States\Response\Templates\QuickReplies $quick_replies */
                $quick_replies = $response_data['data'];

                $responses_entities[] = [
                    'message' => [
                        'text' => $quick_replies->title,
                        'quick_replies' => $quick_replies->buttons
                    ],
                ];
            }

            if ($response_data['type'] == 'location')
            {
                $responses_entities[] = [
                    'message' => [
                        'text' => $response_data['data'],
                        'quick_replies' => [
                            [
                                'content_type' => 'location',
                            ]
                        ]
                    ]
                ];
            }

            if ($response_data['type'] == 'generic_template')
            {
                /** @var \Botomatic\Engine\Facebook\Abstracts\States\Response\Templates\Generic $generic_template */
                $generic_template = $response_data['data'];

                $responses_entities[] = [
                    'message' => [
                        'attachment' => [
                            'type' => 'template',
                            'payload' => [
                                'template_type' => 'generic',
                                'elements' => $generic_template->payloads_templates
                            ]
                        ],
                    ]
                ];
            }

            if ($response_data['type'] == 'list_template')
            {
                /** @var \Botomatic\Engine\Facebook\Abstracts\States\Response\Templates\ListTemplate $list */
                $list = $response_data['data'];

                $responses_entities[] = [
                    'message' => [
                        'attachment' => [
                            'type' => 'template',
                            'payload' => [
                                'template_type' => 'list',
                                'top_element_style' => $list->top_element_style,
                                'elements' => $list->elements,
                                'buttons' => $list->buttons,
                            ]
                        ],
                    ]
                ];
            }
        }

        return $responses_entities;
    }

    /**
     * @return \Curl\Curl
     */
    protected function curl() : \Curl\Curl
    {
        $curl = new \Curl\Curl();
        $curl->setHeader('Content-Type', 'application/json');

        return $curl;
    }

    /**
     * @param \Curl\Curl $curl
     * @param array $message
     */
    protected function process_error(\Curl\Curl $curl, array $message)
    {
        if ($curl->httpStatusCode == 400)
        {
            logger()->error((array) $curl->response);
            logger()->error((array) $message);
        }
    }
}

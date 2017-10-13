<?php

namespace Botomatic\Engine\Platforms\Facebook\Testing;


class Response
{
    /**
     * @var array
     */
    private $bot_responses = [
        'messages' => [],
        'quick_replies' => [],
        'generic' => [],
        'button' => [],
        'location' => false,
        'attachments' => [],
    ];

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var array
     */
    protected $messages = [];

    /**
     * @var array
     */
    protected $response = [];

    /**
     * ResponseProcessor constructor.
     * @param array $responses
     */
    public function __construct(array $responses)
    {
        foreach ($responses as $response)
        {
            /**
             * Find payloads
             */
            if (isset($response->message->quick_replies))
            {
                $quick_replies = $response->message->quick_replies;

                foreach ($quick_replies as $quick_reply)
                {
                    $this->bot_responses['quick_replies'][] = $quick_reply;
                }
            }

            /**
             * Find messages
             */
            if (isset($response->message->text))
            {
                $this->bot_responses['messages'][] = $response->message->text;
            }

            /**
             * Find generic templates
             */
            if (isset($response->message->attachment->payload->template_type))
            {
                if ($response->message->attachment->payload->template_type == 'generic' AND isset($response->message->attachment->payload->elements))
                {
                    foreach ($response->message->attachment->payload->elements as $element)
                    {
                        $this->bot_responses['generic'][] = $element;
                    }
                }

                if ($response->message->attachment->payload->template_type == 'button' AND isset($response->message->attachment->payload->buttons))
                {
                    $this->bot_responses['button'][] = $response->message->attachment->payload;
                }
            }


            if (isset($response->message->attachment->type))
            {
                if (in_array($response->message->attachment->type, ['image', 'file', 'video', 'audio']))
                {
                    $this->bot_responses['attachments'][] = $response->message->attachment;
                }
            }

//            var_dump($this->bot_responses);exit;
        }
    }

    /**
     * @param array $payloads
     * @return $this
     */
    public function hasQuickReplies(array $payloads = [])
    {
        $found = false;

        /**
         * Search if we have quick replies or specific
         */
        if (count($payloads) == 0)
        {
            if (count($this->bot_responses['quick_replies']) > 0)
            {
                $this->messages[] = 'Quick replies found';

                $found = true;
            }
        }
        else
        {
            foreach ($this->bot_responses['quick_replies'] as $quick_reply)
            {
                if (in_array($quick_reply->payload, $payloads))
                {
                    $this->messages[] = 'Payload ' . $quick_reply->payload . ' found';

                    $found = true;
                }
            }
        }


        if (!$found)
        {
            $this->errors[] = 'Payloads not found';
        }

        return $this;
    }


    /**
     * @param $templates
     *
     * @return $this
     */
    public function hasGenericTemplates(array $templates = [])
    {
        if(count($this->bot_responses['generic']) > 0)
        {
            $this->messages[] = 'Generic templates found';
        }
        else
        {
            $this->errors[] = 'Generic templates not found';
        }

        return $this;
    }

    /**
     * @param $templates
     *
     * @return $this
     */
    public function hasButtonTemplates(array $templates = [])
    {
        if(count($this->bot_responses['button']) > 0)
        {
            $this->messages[] = 'Button templates found';
        }
        else
        {
            $this->errors[] = 'Button templates not found';
        }

        return $this;
    }

    /**
     * Return a random generic template payload
     *
     * @return $this
     */
    public function returnRandomGenericElement()
    {
        if (isset($this->bot_responses['generic'][0]))
        {
            $this->response = (array) $this->bot_responses['generic'][0];
        }
        else
        {
            dd($this->bot_responses);
        }

        return $this;
    }

    /**
     * Return a random generic template payload
     *
     * @return $this
     */
    public function hasAttachment()
    {
        if (count($this->bot_responses['attachments']) > 0)
        {
            $this->messages[] = 'Attachments were found';
        }
        else
        {
            $this->errors[] = 'No attachments were found';
        }

        return $this;
    }



    /**
     * Return a random generic template payload
     *
     * @return $this
     */
    public function returnRandomButtonPayload()
    {
        if (isset($this->bot_responses['button'][0]))
        {

            $random_element = array_rand($this->bot_responses['button'][0]->buttons);

            $this->response = $this->bot_responses['button'][0]->buttons[$random_element]->payload;
        }
        else
        {
            dd($this->bot_responses);
        }

        return $this;
    }

    /**
     * Return a random generic template payload
     *
     * @return $this
     */
    public function returnRandomQuickReply()
    {
        if ($this->hasQuickReplies())
        {
            $this->response = (array) $this->bot_responses['quick_replies'][0];
        }

        return $this;
    }

    /**
     * @param string $message
     *
     * @return $this
     */
    public function hasMessage(string $message)
    {
        if (in_array($message, $this->bot_responses['messages']))
        {
            $this->messages[] = 'Message "' . $message .'" was found';
        }
        else
        {
            $this->errors[] = 'Message "' . $message .'" was not found';
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function hasMessages()
    {
        if (count($this->bot_responses['messages']) > 0)
        {
            $this->messages[] = 'Messages were found';
        }
        else
        {
            $this->errors[] = 'No messages were found';
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function hasErrors() : bool
    {
        return count($this->errors) > 0;
    }

    /**
     * @return array
     */
    public function getErrors() : array
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function hasResponse() : array
    {
        return count($this->response);
    }

    /**
     * @return array
     */
    public function getMessages() : array
    {
        return $this->messages;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }
}

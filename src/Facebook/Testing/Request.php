<?php

namespace Botomatic\Engine\Facebook\Testing;

use Botomatic\Engine\Facebook\Localization\Locales;

class Request
{
    /**
     * Repositories
     */
    use \Botomatic\Engine\Facebook\Traits\Repositories\Scopes;
    use \Botomatic\Engine\Core\Traits\Repositories\Users;
    use \Botomatic\Engine\Core\Traits\Repositories\Sessions;


    const FACEBOOK_ID = 123456789;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var array
     */
    protected $basic_structure = [
        'object' => 'page',
        'entry' => [
            [
                'id' => self::FACEBOOK_ID,
                'time' => 1478546806818,
                'messaging' => [
                    [
                        'sender' => [
                            'id' => self::FACEBOOK_ID
                        ],
                        'recipient' => [
                            'id' => self::FACEBOOK_ID
                        ],
                        'timestamp' => 1478546806731,
                    ]
                ]
            ]
        ],
    ];

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->url = url('webhook/facebook');
    }


    /**
     * Reset user
     */
    public function newUser()
    {
        /**
         * If user exists, delete it along with his session
         */
        $user = $this->botomaticRepositoryUser()->findByFacebook(self::FACEBOOK_ID);

        if (!$user->isEmpty())
        {
            \DB::transaction(function () use ($user)
            {
                /**
                 * If session exists remove it along with the state
                 */
                $session = $this->botomaticRepositorySessions()->findByUser($user);

                if (!$session->isEmpty())
                {
                    $this->botomaticFacebookRepositoryScopes()->removeBySession($session);

                    $this->botomaticRepositorySessions()->delete($session);
                }

                $this->botomaticRepositoryUser()->delete($user);
            });
        }

        $user = new \Botomatic\Engine\Core\Entities\User();

        $user->setFacebookId(self::FACEBOOK_ID);
        $user->setFacebookPage(self::FACEBOOK_ID);
        $user->setFirstName('Test');
        $user->setLastName('Test');
        $user->setImage('test_image');
        $user->setLocale(Locales::en_US);

        $this->botomaticRepositoryUser()->insert($user);
    }


    /**
     * @param string $message
     *
     * @return array
     */
    public function sendMessage($message)
    {
        $data = [
            'text' => $message,
        ];

        return $this->curl($data);
    }

    /**
     * @param string $quick_reply
     *
     * @return array
     */
    public function sendQuickReply($quick_reply)
    {
        $data = [
            'quick_reply' => [
                'payload' => $quick_reply,
            ]
        ];

        return $this->curl($data);
    }

    /**
     * @param string $postback
     *
     * @return array
     */
    public function sendPostback($postback)
    {
        $data = [
            'payload' => $postback,
        ];

        return $this->curlPostback($data);
    }

    /**
     * @param string $postback
     * @param array $referral
     *
     * @return array
     */
    public function sendPostbackWithReferral($postback, $referral = [])
    {
        $data = [
            'payload' => $postback,
        ];

        if (count($referral) > 0)
        {
            $data['referral'] = $referral;
        }

        return $this->curlPostback($data);
    }

    /**
     * @param \Botomatic\Engine\Core\Entities\Location $location
     *
     * @return array
     */
    public function sendLocation(\Botomatic\Engine\Core\Entities\Location $location)
    {
        $data = [
            'attachments' => [
                [
                    'type' => 'location',
                    'payload' => [
                        'coordinates' => [
                            'lat' => $location->getLatitude(),
                            'long' => $location->getLongitude(),
                        ]
                    ],
                ]
            ]
        ];

        return $this->curl($data);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function curl(array $data) : array
    {
        $data_to_send = $this->basic_structure;
        $data_to_send['entry'][0]['messaging'][0]['message'] = $data;

        $curl = new \Curl\Curl();
        $curl->post($this->url, $data_to_send);
        $curl->close();

        if (!is_array($curl->response))
        {
            dd($curl->response);
        }

        return $curl->response;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function curlPostback(array $data) : array
    {
        $data_to_send = $this->basic_structure;
        $data_to_send['entry'][0]['messaging'][0]['postback'] = $data;

        $curl = new \Curl\Curl();
        $curl->post($this->url, $data_to_send);
        $curl->close();

        if (!is_array($curl->response))
        {
            dd($curl->response);
        }

        return $curl->response;
    }
}

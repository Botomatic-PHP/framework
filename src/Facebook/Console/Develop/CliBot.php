<?php

namespace Botomatic\Engine\Facebook\Console\Develop;

use Botomatic\Engine\Facebook\Localization\Locales;
use Illuminate\Console\Command;

/**
 * Class Facebook
 * @package Botomatic\Engine\Commands\Setup
 */
class CliBot extends Command
{
    const FACEBOOK_ID = 99999999999;
    const FACEBOOK_PAGE_ID = 88888888888;

    /**
     * Repositories
     */
    use \Botomatic\Engine\Facebook\Traits\Repositories\Scopes;
    use \Botomatic\Engine\Core\Traits\Repositories\Users;
    use \Botomatic\Engine\Core\Traits\Repositories\Sessions;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bf:cli {--raw}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Interact with the bot via cli';

    /**
     * @var array
     */
    protected $message_basic_structure = [
        'object' => 'page',
        'entry' => [
            [
                'id' => self::FACEBOOK_PAGE_ID,
                'time' => 1478546806818,
                'messaging' => [
                    [
                        'sender' => [
                            'id' => self::FACEBOOK_ID
                        ],
                        'recipient' => [
                            'id' => self::FACEBOOK_PAGE_ID
                        ],
                        'timestamp' => 1478546806731,
                    ]
                ]
            ]
        ],
    ];

    /**
     * @var string
     */
    protected $url;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->check_environment();

        $this->url = env('BOTOMATIC_FACEBOOK_TEST_URL');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->newUser();

        try
        {
            $input = $this->ask('Starting CLI Bot...');

            return $this->resolve_bot_response($this->sendMessage($input));

        }
        catch (\Exception $e)
        {
            $this->error($e->getMessage());
            $this->error($e->getFile());
            $this->error($e->getLine());
        }
    }

    /*------------------------------------------------------------------------------------------------------------------
     *
     * Environment methods
     *
     -----------------------------------------------------------------------------------------------------------------*/
    /**
     * Check if the the App is running in local environment
     */
    protected function check_environment()
    {
        if (!app()->isLocal())
        {
            dd('CLI Bot can only run in local environment');
        }

        if (env('BOTOMATIC_FACEBOOK_DEBUG') != true)
        {
            dd('CLI Bot can only run debug mode');
        }
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

        /**
         * Create the new user
         */

        $user = new \Botomatic\Engine\Core\Entities\User();

        $user->setFacebookId(self::FACEBOOK_ID);
        $user->setFacebookPage(self::FACEBOOK_PAGE_ID);
        $user->setFirstName('Test');
        $user->setLastName('Test');
        $user->setImage('test_image');
        $user->setLocale(Locales::en_US);

        $this->botomaticRepositoryUser()->insert($user);
    }



    /*------------------------------------------------------------------------------------------------------------------
     *
     * Request / Response
     *
     -----------------------------------------------------------------------------------------------------------------*/

    /**
     * @param string $message
     *
     * @return array
     */
    protected function sendMessage(string $message) : array
    {
        $data_to_send = $this->message_basic_structure;
        $data_to_send['entry'][0]['messaging'][0]['message'] = [
            'text' => $message,
        ];

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
     * @param string $data
     *
     * @return array
     */
    protected function sendPostback(string $data) : array
    {
        $data_to_send = $this->message_basic_structure;
        $data_to_send['entry'][0]['messaging'][0]['postback']['payload'] = $data;

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
     * @param array $responses
     */
    protected function resolve_bot_response(array $responses)
    {
        /**
         * If we don't have any responses
         */
        if (count($responses) == 0)
        {
            $this->comment('no response from the bot');
            $this->ask('');
        }
        else
        {

            $response_postbacks = [];

            foreach ($responses as $response)
            {

                if (isset($response->delay))
                {
                    $this->comment('Typing...');

                    sleep($response->delay);

                    continue;
                }

                /*
                 * Extract the body
                 */
                $response = (array)$response->message;


                /*------------------------------------------------------------------------------------------------------
                 *
                 * Regular message
                 *
                 -----------------------------------------------------------------------------------------------------*/
                if (isset($response['text']))
                {
                    $this->comment($response['text']);
                }

                /*------------------------------------------------------------------------------------------------------
                 *
                 * Check if we have quick replies
                 *
                 -----------------------------------------------------------------------------------------------------*/
                if (isset($response['quick_replies']))
                {
                    $quick_replies = '';

                    foreach ($response['quick_replies'] as $quick_reply)
                    {
                        $quick_replies .= ' [' . $quick_reply->title . '] ';

                        $response_postbacks[$quick_reply->title] = $quick_reply->payload;
                    }

                    $this->info('Quick Replies: ' . $quick_replies);
                }

                /*------------------------------------------------------------------------------------------------------
                 *
                 * Check if we have a template
                 *
                 -----------------------------------------------------------------------------------------------------*/
                if (isset($response['attachment']) AND $response['attachment']->type == 'template')
                {

                    /*--------------------------------------------------------------------------------------------------
                     *
                     * Button template
                     *
                     -------------------------------------------------------------------------------------------------*/
                    if ($response['attachment']->payload->template_type == 'button')
                    {

                        $this->info('Button template:');
                        $this->info($response['attachment']->payload->text);

                        $response_postbacks = [];

                        foreach ($response['attachment']->payload->buttons as $button)
                        {
                            $this->info(' [' . $button->title . '] ');

                            $response_postbacks[$button->title] = $button->payload;
                        }
                    }

                    /*--------------------------------------------------------------------------------------------------
                     *
                     * Generic template
                     *
                     -------------------------------------------------------------------------------------------------*/
                    if ($response['attachment']->payload->template_type == 'generic')
                    {

                        $this->info('Generic template:');

                        $response_postbacks = [];

                        foreach ($response['attachment']->payload->elements as $element)
                        {

                            $this->info('-----------------------');

                            $this->info($element->title);
                            $this->info($element->subtitle);
                            $this->info($element->image_url);

                            foreach ($element->buttons as $button)
                            {
                                $this->info(' [' . $button->title . '] ');
                                $response_postbacks[$button->title] = $button->payload;
                            }

                            $this->info("-----------------------\n");

                        }
                    }
                }
            }


            /*----------------------------------------------------------------------------------------------------------
             *
             * Continue... capture the input and process again
             *
             ---------------------------------------------------------------------------------------------------------*/


            $input = $this->ask('');

            /*----------------------------------------------------------------------------------------------------------
             *
             * Check for postbacks
             *
             ---------------------------------------------------------------------------------------------------------*/
            if (count($response_postbacks) > 0)
            {
                if (isset($response_postbacks[$input]))
                {
                    return $this->resolve_bot_response (
                        $this->sendPostback($response_postbacks[$input])
                    );

                }
            }

            return $this->resolve_bot_response($this->sendMessage($input));
        }
    }

    /*------------------------------------------------------------------------------------------------------------------
     *
     * Helpers
     *
     -----------------------------------------------------------------------------------------------------------------*/


}

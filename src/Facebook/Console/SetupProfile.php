<?php

namespace Botomatic\Engine\Facebook\Console;

use Botomatic\Engine\Core\Console\BotomaticCommands;

/**
 * Class SetupProfile
 * @package Botomatic\Engine\Facebook\Console
 */
class SetupProfile extends BotomaticCommands
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'botomatic:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup facebook bot';

    /**
     * @var array
     */
    private $access_tokens;

    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    protected $configuration;

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->access_tokens = config('botomatic.facebook.pages');
        $this->configuration = config('botomatic.facebook.profile');

        $this->url = 'https://graph.facebook.com/' . env('BOTOMATIC_FACEBOOK_GRAPH_VERSION', 'v2.9') . "/me/messenger_profile?access_token=";
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->print_botomatic();

        try
        {
            foreach ($this->access_tokens as $access_token)
            {
                $this->info("\n Setup get started button \n");
                $this->setupGetStartedButton($access_token);


                $this->info("\n Setup greeting text \n");
                $this->setupGreetingText($access_token);

                $this->info("\n Setup Persistent Menu \n");
                $this->setupPersistentMenu($access_token);

                $this->info("\n Get settings \n");

                $curl = new \Curl\Curl();

                $curl->get($this->url . $access_token . '&fields=get_started,greeting,persistent_menu');

                var_dump($curl->response);
            }

        }
        catch (\Exception $e)
        {
            $this->error($e->getMessage());
        }
    }

    /**
     * @param string $access_token
     */
    protected function setupGetStartedButton(string $access_token)
    {
        $curl = new \Curl\Curl();

        /**
         * Delete existing button
         */
        $post_data = [
            'fields' =>[
                'get_started'
            ],
        ];

        $curl->delete($this->url. $access_token, $post_data);
        $this->comment($curl->rawResponse);

        /**
         * Create new button
         */
        $post_data_get_started = [
            'get_started' => [
                'payload' => $this->configuration['get_started_button'],
            ],
        ];

        $curl->post($this->url . $access_token, $post_data_get_started);
        $this->comment("\n" . $curl->rawResponse);
    }

    /**
     * @param string $access_token
     */
    protected function setupGreetingText(string $access_token)
    {
        $curl = new \Curl\Curl();

        /**
         * Delete existing
         */
        $post_data = [
            'fields' =>[
                'greeting'
            ],
        ];

        $curl->delete($this->url. $access_token, $post_data);
        $this->comment($curl->rawResponse);

        /**
         * Create new
         */
        $post_data_greeting = [
            'greeting' => $this->configuration['greeting_text']
        ];

        $curl->post($this->url . $access_token, $post_data_greeting);
        $this->comment("\n" . $curl->rawResponse);
    }

    /**
     * @param string $access_token
     */
    protected function setupPersistentMenu(string $access_token)
    {
        $curl = new \Curl\Curl();

        /**
         * Delete existing
         */
        $post_data = [
            'fields' =>[
                'persistent_menu'
            ],
        ];

        $curl->delete($this->url . $access_token, $post_data);
        $this->comment($curl->rawResponse);

        /**
         * Create new
         */
        $post_data_greeting = [
            'persistent_menu' => $this->configuration['persistent_menu']
        ];

        $curl->post($this->url . $access_token, $post_data_greeting);
        $this->comment("\n" . $curl->rawResponse);
    }
}

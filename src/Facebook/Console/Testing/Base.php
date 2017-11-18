<?php

namespace Botomatic\Engine\Facebook\Console\Testing;

use Closure;
use Illuminate\Console\Command;

/**
 * Class Base
 * @package Botomatic\Engine\Facebook\Console\Testing
 */
class Base extends Command
{

    use \Botomatic\Engine\Facebook\Traits\Repositories\Scopes;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';


    /**
     * @var \Botomatic\Engine\Facebook\Testing\Request
     */
    protected $request;

    /**
     * Basic constructor.
     */
    public function __construct()
    {
        parent::__construct();

        /**
         * Request builder
         */
        $this->request = app()->make(\Botomatic\Engine\Facebook\Testing\Request::class);
    }


    /**
     * Removes test user (if exists)
     */
    protected function newUser()
    {
        $this->info('Create new user...');
        $this->request->newUser();
    }


    /**
     * @param string $message
     * @param Closure $response
     *
     * @return array
     */
    protected function sendMessage(string $message, Closure $response)
    {

        $this->info('User: ' . $message);
        $curl_response = $this->request->sendMessage($message);

        /** @var \Botomatic\Engine\Platforms\Facebook\Testing\Response $response_processed */
        $response_processed = $response(new \Botomatic\Engine\Platforms\Facebook\Testing\Response($curl_response));

        if ($response_processed->hasErrors())
        {
            foreach ($response_processed->getErrors() as $error)
            {
                $this->error($error);
            }

            var_dump($curl_response);exit;
        }
        else
        {
            foreach ($response_processed->getMessages() as $message)
            {
                $this->info('Bot: ' . $message);
            }
        }

        /**
         * Do we have responses?
         */
        return $response_processed->getResponse();
    }


    /**
     * @param string $quick_reply
     * @param Closure $response
     *
     * @return array
     */
    protected function sendQuickReply(string $quick_reply, Closure $response) : array
    {

        try
        {
            $this->info('User: ' . $quick_reply);
            $curl_response = $this->request->sendQuickReply($quick_reply);

            /** @var \Botomatic\Engine\Platforms\Facebook\Testing\Response $response_processed */
            $response_processed = $response(new \Botomatic\Engine\Platforms\Facebook\Testing\Response($curl_response));

            if ($response_processed->hasErrors())
            {
                foreach ($response_processed->getErrors() as $error)
                {
                    $this->error($error);
                }

                var_dump($curl_response);exit;
            }
            else
            {
                foreach ($response_processed->getMessages() as $message)
                {
                    $this->info('Bot: ' . $message);
                }
            }

            /**
             * Do we have responses?
             */
            return $response_processed->getResponse();
        }
        catch (\Exception $exception)
        {
            var_dump($exception->getMessage(), $exception->getFile(), $exception->getLine());exit;
        }
    }

    /**
     * @param string $postback
     * @param Closure $response
     *
     * @return mixed
     */
    protected function sendPostback(string $postback, Closure $response)
    {

        try
        {
            $this->info('User: ' . $postback);
            $curl_response = $this->request->sendPostback($postback);

            /** @var \Botomatic\Engine\Platforms\Facebook\Testing\Response $response_processed */
            $response_processed = $response(new \Botomatic\Engine\Platforms\Facebook\Testing\Response($curl_response));

            if ($response_processed->hasErrors())
            {
                foreach ($response_processed->getErrors() as $error)
                {
                    $this->error($error);
                }

                var_dump($curl_response);exit;
            }
            else
            {
                foreach ($response_processed->getMessages() as $message)
                {
                    $this->info('Bot: ' . $message);
                }
            }

            /**
             * Do we have responses?
             */
            return $response_processed->getResponse();
        }
        catch (\Exception $exception)
        {
            var_dump($exception->getMessage(), $exception->getFile(), $exception->getLine());exit;
        }
    }

    /**
     * Create the conditions of a timeout for the test state
     */
    protected function setTimeout()
    {
        /*
         * Find the last state and set a timeout in the past
         */
        $state = $this->botomaticFacebookRepositoryScopes()->findLast();

        $state->setTimeout(\Carbon\Carbon::yesterday());

        $this->botomaticFacebookRepositoryScopes()->update($state);
    }

    /**
     * @param \Botomatic\Engine\Core\Entities\Location $location
     * @param Closure $response
     *
     * @return array
     */
    protected function sendLocation(\Botomatic\Engine\Core\Entities\Location $location, Closure $response) : array
    {
        try
        {
            $this->info('User: location');
            $curl_response = $this->request->sendLocation($location);

            /** @var \Botomatic\Engine\Platforms\Facebook\Testing\Response $response_processed */
            $response_processed = $response(new \Botomatic\Engine\Platforms\Facebook\Testing\Response($curl_response));

            if ($response_processed->hasErrors())
            {
                foreach ($response_processed->getErrors() as $error)
                {
                    $this->error($error);
                }

                var_dump($curl_response);exit;
            }
            else
            {
                foreach ($response_processed->getMessages() as $message)
                {
                    $this->info('Bot: ' . $message);
                }
            }

            /**
             * Do we have responses?
             */
            return $response_processed->getResponse();
        }
        catch (\Exception $exception)
        {
            var_dump($exception->getMessage(), $exception->getFile(), $exception->getLine());exit;
        }

    }

}

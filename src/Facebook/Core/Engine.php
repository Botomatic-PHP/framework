<?php

namespace Botomatic\Engine\Facebook\Core;
use Botomatic\Engine\Facebook\Localization\Localizator;

/**
 * Class Engine
 * @package Botomatic\Engine\Platforms\Facebook
 */
class Engine
{

    /**
     * Repositories
     */
    use \Botomatic\Engine\Facebook\Traits\Repositories\Scopes;

    /**
     * @var \Botomatic\Engine\Core\Entities\Session
     */
    private $session;

    /**
     * @var \Botomatic\Engine\Facebook\Entities\Message
     */
    private $message;

    /**
     * @var \Botomatic\Engine\Facebook\Core\Scope
     */
    protected $scope;

    /**
     * @var \Botomatic\Engine\Facebook\Entities\Scope
     */
    protected $scope_entity;

    /**
     * @var \Botomatic\Engine\Facebook\Entities\Response
     */
    protected $response;

    /**
     * @var \Botomatic\Engine\Facebook\Core\Dispatcher
     */
    protected $facebook_dispatcher;

    /**
     * @var array
     */
    protected $response_for_facebook = [];

    /**
     * @var bool
     */
    protected $debug = true;

    /**
     * @param \Botomatic\Engine\Core\Entities\Session $session
     * @param \Botomatic\Engine\Facebook\Entities\Message $message
     */
    public function __construct(\Botomatic\Engine\Core\Entities\Session $session, \Botomatic\Engine\Facebook\Entities\Message $message)
    {
        $this->session = $session;
        $this->message = $message;

        /*
         * Object that dispatches responses to facebook
         */
        $this->facebook_dispatcher = new \Botomatic\Engine\Facebook\Core\Dispatcher($session);

        /*
         * In debug mode, the responses are not sent to facebook
         */
        $this->debug = env('BOTOMATIC_FACEBOOK_DEBUG');

        /*
         * Call the bootstrap
         */
        $bootstrap = config('botomatic.facebook.bootstrap');

        new $bootstrap($session);
    }

    public function process()
    {
        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * Search for scope in DB
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
        $this->scope_entity = $this->botomaticFacebookRepositoryScopes()->findBySession($this->session);


        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * If there's no active scope instantiate new
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
        if ($this->scope_entity->isEmpty())
        {
            $this->scope = new \Botomatic\Engine\Facebook\Core\Scope();
        }
        else
        {
            $this->scope = $this->scope_entity->getScope();
        }


        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * Start typing
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
        if (!$this->debug)
        {
            $this->facebook_dispatcher->typingOn($this->session);
        }

        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * Process the message
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
        $this->response = $this->scope->handleMessage($this->message, $this->session);


        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * Dispatch response
         *
         *
         -------------------------------------------------------------------------------------------------------------*/

        if (!$this->debug)
        {
            /**
             * Send response to facebook
             */
             $this->facebook_dispatcher->sendResponse($this->response, $this->session);

            /**
             * If we log each request/response
             */
            if (env('BOTOMATIC_FACEBOOK_LOG_REQUESTS', false) == true)
            {
                \Botomatic\Engine\Core\Debug\Logger::requestFromFacebook(
                    $this->session->getUser(),
                    $this->facebook_dispatcher->composeResponse($this->response)
                );
            }
        }
        else
        {
            /**
             * Return response for output
             */
            $this->response_for_facebook = $this->facebook_dispatcher->composeResponse($this->response);
        }


        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * Look for timeout
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
        if ($this->scope->getActiveState()->hasTimeout())
        {
            $this->scope_entity->setTimeout($this->scope->getActiveState()->getTimeout());
        }


        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * Save or create new entry
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
        $this->scope_entity->setScope($this->scope);

        if ($this->scope_entity->isEmpty())
        {
            $this->scope_entity->setSession($this->session);

            $this->botomaticFacebookRepositoryScopes()->insert($this->scope_entity);
        }
        else
        {
            $this->botomaticFacebookRepositoryScopes()->update($this->scope_entity);
        }

    }

    /**
     * @return array
     */

    public function getResponse()
    {
        return $this->response_for_facebook;
    }
}
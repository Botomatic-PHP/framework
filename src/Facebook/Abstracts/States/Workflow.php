<?php

namespace Botomatic\Engine\Facebook\Abstracts\States;

/**
 * Class Workflow
 * @package Botomatic\Engine\Facebook\Abstracts\States
 */
abstract class Workflow extends Base
{
    /*------------------------------------------------------------------------------------------------------------------
     *
     *
     * Serialization properties
     *
     *
     ------------------------------------------------------------------------------------------------------------------*/

    /**
     * All attributes that we want to serialize when we save the state
     *
     * @var array
     */
    protected $serializes = [];

    /**
     * Fields that we always serialize
     *
     * @var array
     */
    private $serializes_base = ['serializes', 'timeout', 'timeout_minutes'];


    /*------------------------------------------------------------------------------------------------------------------
     *
     *
     * Timeout properties
     *
     *
     ------------------------------------------------------------------------------------------------------------------*/

    /**
     * @var int
     */
    protected $timeout_minutes = 0;

    /**
     * @var \Carbon\Carbon
     */
    protected $timeout = null;


    /**
     * @param \Botomatic\Engine\Facebook\Entities\Message $message
     * @param \Botomatic\Engine\Facebook\Entities\Response $response
     * @param \Botomatic\Engine\Core\Entities\Session $session
     *
     * @return \Botomatic\Engine\Facebook\Entities\Response
     *
     * @throws \Botomatic\Engine\Platforms\Facebook\Exceptions\State\MessageHandlerMissing
     */
    public function handle(\Botomatic\Engine\Facebook\Entities\Message $message,
                           \Botomatic\Engine\Facebook\Entities\Response $response,
                           \Botomatic\Engine\Core\Entities\Session $session) : \Botomatic\Engine\Facebook\Entities\Response
    {
        $this->session = $session;

        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * Find Message and Response handlers
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
        $this->setup();


        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * Add the message and response entities to their handlers
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
        $this->message->setMessage($message);
        $this->response->setResponse($response);

        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * Check for timeout
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
        if ($this->isTimeout())
        {
            return $this->timeoutResponse($this->response->response());
        }


        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * Process logic specific to State
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
        $response = $this->process();

        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * Set timeout
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
        $this->setTimeout();


        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * Return the response
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
         return $response;
    }




    /*------------------------------------------------------------------------------------------------------------------
     *
     *
     * Sleep / Wakeup
     *
     *
     -----------------------------------------------------------------------------------------------------------------*/

    /**
     * @return array
     */
    public function __sleep() : array
    {
        $this->sleep();

        $this->setTimeout();

        return array_merge($this->serializes, $this->serializes_base);
    }

    /**
     * @return array
     */
    public function __wakeup()
    {
        $this->setup();

        $this->wakeup();
    }


    /**
     * Method called when __sleep() is called
     */
    public function sleep() {}

    /**
     * Method called when __wakeup() is called
     */
    public function wakeup() {}


    /*------------------------------------------------------------------------------------------------------------------
     *
     *
     * Timeout actions
     *
     *
     -----------------------------------------------------------------------------------------------------------------*/

    /**
     * @return int
     */
    public function getTimeoutMinutes() : int
    {
        return $this->timeout_minutes;
    }

    /**
     * @return \Carbon\Carbon | null
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * If we have timeout minutes calculate/set
     */
    public function setTimeout()
    {
        if ($this->timeout_minutes > 0)
        {
            $this->timeout = \Carbon\Carbon::now()->addMinutes($this->getTimeoutMinutes());
        }
    }

    /**
     * @return bool
     */
    public function isTimeout() : bool
    {
        if ($this->hasTimeout() AND $this->timeout->gte(\Carbon\Carbon::now()))
        {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function hasTimeout() : bool
    {
        return ($this->timeout instanceof \Carbon\Carbon);
    }

    /**
     * @param \Botomatic\Engine\Facebook\Entities\Response $response
     *
     * @return \Botomatic\Engine\Facebook\Entities\Response
     */
    public function timeoutResponse(\Botomatic\Engine\Facebook\Entities\Response $response) : \Botomatic\Engine\Facebook\Entities\Response
    {
        $response->addMessage('This is the timeout')
            ->sendResponse();

        return $response;
    }


    /*------------------------------------------------------------------------------------------------------------------
     *
     *
     * State object specific
     *
     *
     -----------------------------------------------------------------------------------------------------------------*/
    /**
     * @return string
     */
    public function getSignature() : string
    {
        return static::class;
    }

}

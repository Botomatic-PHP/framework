<?php

namespace Botomatic\Engine\Facebook\Abstracts\States;

/**
 * Class Base
 * @package Botomatic\Engine\Facebook\Abstracts\States
 *
 * Base Object for Workflow and Filter states
 */
abstract class Base
{


    /*------------------------------------------------------------------------------------------------------------------
     *
     *
     * Message, Response, Session
     *
     *
     ------------------------------------------------------------------------------------------------------------------*/

    /**
     * @var \Botomatic\Engine\Facebook\Abstracts\States\Message\Handler
     */
    protected $message = null;

    /**
     * @var \Botomatic\Engine\Facebook\Abstracts\States\Response\Handler
     */
    protected $response = null;

    /**
     * @var \Botomatic\Engine\Core\Entities\Session
     */
    protected $session;


    /*------------------------------------------------------------------------------------------------------------------
     *
     *
     * Methods needed to be defined by the state
     *
     *
     -----------------------------------------------------------------------------------------------------------------*/

    /**
     * Logic specific to the state
     *
     * @return \Botomatic\Engine\Facebook\Entities\Response
     */
    protected abstract function process() : \Botomatic\Engine\Facebook\Entities\Response;



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

    /**
     * Find Message and Response handlers
     */
    protected function setup()
    {
        $reflection = new \ReflectionClass(static::class);

        $namespace = $reflection->getNamespaceName();

        $responses = '\\'.$namespace .'\\Handlers\\Responses';
        $message = '\\'.$namespace .'\\Handlers\\Message';

        try
        {
            $this->response = new $responses();
            $this->message = new $message();
        }
        catch (\Exception $exception)
        {
            // create the missing files?
        }
    }
}

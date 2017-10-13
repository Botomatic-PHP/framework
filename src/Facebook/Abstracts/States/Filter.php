<?php

namespace Botomatic\Engine\Facebook\Abstracts\States;

/**
 * Class Filter
 * @package Botomatic\Engine\Facebook\Abstracts\States
 */
abstract class Filter extends Base
{
    /**
     * @var bool
     */
    protected $jump_to_state = false;

    /**
     * If a workflow state is defined the scope will jump to it
     *
     * @var \Botomatic\Engine\Facebook\Abstracts\States\Workflow
     */
    protected $workflow_state = null;

    /**
     * @param \Botomatic\Engine\Facebook\Entities\Message $message
     * @param \Botomatic\Engine\Facebook\Entities\Response $response
     * @param \Botomatic\Engine\Core\Entities\Session $session
     *
     * @return Filter
     *
     * @throws \Botomatic\Engine\Platforms\Facebook\Exceptions\State\MessageHandlerMissing
     */
    public function handle(\Botomatic\Engine\Facebook\Entities\Message $message,
                           \Botomatic\Engine\Facebook\Entities\Response $response,
                           \Botomatic\Engine\Core\Entities\Session $session) : \Botomatic\Engine\Facebook\Abstracts\States\Filter
    {
        $this->response = $response;
        $this->session = $session;

        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * Find Handlers
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
         * Update the response handler with the new processed response
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
        $this->response->setResponse($this->process());

        return $this;
    }



    /*------------------------------------------------------------------------------------------------------------------
     *
     *
     * Actions methods
     *
     *
     -----------------------------------------------------------------------------------------------------------------*/
    /**
     * @return \Botomatic\Engine\Facebook\Entities\Response
     */
    public function getResponse() : \Botomatic\Engine\Facebook\Entities\Response
    {
        return $this->response->response();
    }

    /**
     * @return bool
     */
    public function wantsToJumps() : bool
    {
        return $this->jump_to_state;
    }

    /**
     * @return Workflow
     */
    public function getWorkflowState() : \Botomatic\Engine\Facebook\Abstracts\States\Workflow
    {
        return new $this->workflow_state();
    }

    /**
     * @param Workflow $workflow
     *
     * @return \Botomatic\Engine\Facebook\Entities\Response
     */
    public function jumpToWorkflowState(\Botomatic\Engine\Facebook\Abstracts\States\Workflow $workflow) : \Botomatic\Engine\Facebook\Entities\Response
    {
        $this->workflow_state = $workflow;

        $this->jump_to_state = true;

        return $this->response->response();
    }

}

<?php

namespace Botomatic\Engine\Facebook\Core;

/**
 * Class Scope
 * @package Botomatic\Engine\Facebook\Core
 */
class Scope
{
    /**
     * Fields that we serialize
     *
     * @var array
     */
    protected $serializes = ['serializes', 'active_state'];

    /**
     * @var \Botomatic\Engine\Facebook\Abstracts\States\Workflow
     */
    protected $active_state = null;

    /**
     * @var \Botomatic\Engine\Facebook\Core\Router
     */
    protected $router;

    /**
     * Scope constructor.
     */
    public function __construct()
    {
        $this->router = new \Botomatic\Engine\Facebook\Core\Router();
    }

    /**
     *
     * @param \Botomatic\Engine\Facebook\Entities\Message $message
     * @param \Botomatic\Engine\Core\Entities\Session $session
     *
     * @return \Botomatic\Engine\Facebook\Entities\Response
     */
    public function handleMessage(\Botomatic\Engine\Facebook\Entities\Message $message,
                                  \Botomatic\Engine\Core\Entities\Session $session) : \Botomatic\Engine\Facebook\Entities\Response
    {
        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * The response object is passed to each state
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
        $response = new \Botomatic\Engine\Facebook\Entities\Response();


        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * Set the active state, if any
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
        if (!is_null($this->active_state))
        {
            $response->setActiveState($this->getActiveState());
        }


        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * Process Postbacks, if any
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
        if ($message->isCallbackPostback())
        {
            /** @var \Botomatic\Engine\Facebook\Abstracts\States\Filter $filter */
            foreach ($this->router->getPostbacks() as $filter)
            {
                $filter = new $filter();

                $filter->handle($message, $response, $session);

                /**
                 * Do we jump to a Workflow state?
                 */
                if ($filter->wantsToJumps())
                {

                    $this->setActiveState($filter->getWorkflowState());

                    /**
                     * Check if we should stop and respond
                     */
                    if ($filter->getResponse()->wantsToSendReponse())
                    {
                        return $filter->getResponse();
                    }

                    /**
                     * Stop filters
                     */
                    continue;
                }
                /**
                 * Else assign the response and continue
                 */
                else
                {
                    /**
                     * Update the response
                     */
                    $response = $filter->getResponse();


                    /**
                     * Check if we should stop and respond
                     */
                    if ($response->wantsToSendReponse())
                    {
                        return $response;
                    }

                    // continue
                }
            }
        }


        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * Process filters
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
        /** @var \Botomatic\Engine\Facebook\Abstracts\States\Filter $filter */
        foreach ($this->router->getFilters() as $filter)
        {
            $filter = new $filter();

            $filter->handle($message, $response, $session);

            /**
             * Do we jump to a Workflow state?
             */
            if ($filter->wantsToJumps())
            {

                $this->setActiveState($filter->getWorkflowState());

                /**
                 * Check if we should stop and respond
                 */
                if ($filter->getResponse()->wantsToSendReponse())
                {
                    return $filter->getResponse();
                }

                /**
                 * Stop filters
                 */
                continue;
            }
            /**
             * Else assign the response and continue
             */
            else
            {
                /**
                 * Update the response
                 */
                $response = $filter->getResponse();

                /**
                 * Check if we should stop and respond
                 */
                if ($response->wantsToSendReponse())
                {
                    return $response;
                }

                // continue
            }
        }

        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * Process the active state
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
        $response = $this->getActiveState()->handle($message, $response, $session);


        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * If the status is not "Active" the State finished and the next State needs to be set
         *
         * Note: If setting the next state fails it moves to the listener
         *
         -------------------------------------------------------------------------------------------------------------*/
        if (!$response->isActive())
        {
            $this->setActiveState($this->router->getNextState($this->getActiveState(), $response));
        }


        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * If respond flag is set stop and respond
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
        if ($response->wantsToSendReponse())
        {
            return $response;
        }


        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * If respond flag was not set we iterate until we encounter it
         *
         * First process the active state then iterate until one state is active.
         *
         * Note: if routing or statuses are not handled properly it might cause an infinite loop
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
        $response = $this->getActiveState()->handle($message, $response, $session);

        while (!$response->isActive())
        {
            $this->setActiveState($this->router->getNextState($this->getActiveState(), $response));

            $response = $this->getActiveState()->handle($message, $response, $session);
        }

        return $response;
    }


    /**
     * @return \Botomatic\Engine\Facebook\Abstracts\States\Workflow
     */
    public function getActiveState() : \Botomatic\Engine\Facebook\Abstracts\States\Workflow
    {
       if (is_null($this->active_state))
       {
           $this->active_state = $this->router->getListener();
       }
       return $this->active_state;
    }

    /**
     * @param \Botomatic\Engine\Facebook\Abstracts\States\Workflow $state
     *
     * @return \Botomatic\Engine\Facebook\Abstracts\States\Workflow
     */
    public function setActiveState(\Botomatic\Engine\Facebook\Abstracts\States\Workflow $state) : \Botomatic\Engine\Facebook\Abstracts\States\Workflow
    {
        $this->active_state = $state;

        return $this->getActiveState();
    }


    /**
     * @return array
     */
    public function __sleep() : array
    {
        return $this->serializes;
    }

    /**
     * Called when object is unserialized
     */
    public function __wakeup()
    {
        $this->router = new \Botomatic\Engine\Facebook\Core\Router();
    }

}
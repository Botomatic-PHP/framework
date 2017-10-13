<?php

namespace Botomatic\Engine\Facebook\Entities;

/**
 * Class Response
 * @package Botomatic\Engine\Facebook\Entities
 */
class Response
{

    /*----------------------------------------------------------------------------------------------------------------
     *
     * Statuses
     *
     ----------------------------------------------------------------------------------------------------------------*/

    /**
     * Default status
     */
    const STATUS_ACTIVE = 0;

    /**
     * The state has finished it's role and has achieved win-state.
     *
     * Note: This state does not force to return the response.
     *
     * @const int
     */
    const STATUS_FINISH = 1;

    /**
     * @const int
     */
    const STATUS_TIMEOUT = 3;


    /*----------------------------------------------------------------------------------------------------------------
     *
     * Attributes
     *
     ----------------------------------------------------------------------------------------------------------------*/

    /**
     * @var int
     */
    protected $status = self::STATUS_ACTIVE;

    /**
     * When set to true, it stops the flow and responds
     *
     * @var bool
     */
    protected $send_response = false;

    /**
     * The active state of the Scope
     *
     * @var \Botomatic\Engine\Facebook\Abstracts\States\Workflow
     */
    protected $active_state = null;

    /**
     * @var array
     */
    protected $responses = [];


    /*----------------------------------------------------------------------------------------------------------------
     *
     * Methods
     *
     ----------------------------------------------------------------------------------------------------------------*/


    /**
     * Instructs the engine to stop and respond
     */
    public function sendResponse()
    {
        $this->send_response = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function wantsToSendReponse() : bool
    {
        return $this->send_response == true;
    }

    /**
     * @param int $seconds
     *
     * @return $this
     */
    public function delay($seconds = 1)
    {
        $this->responses[] = [
            'data' => $seconds,
            'type' => 'delay',
        ];

        return $this;
    }


    /**
     * @return \Botomatic\Engine\Facebook\Abstracts\States\Workflow
     */
    public function getActiveState(): \Botomatic\Engine\Facebook\Abstracts\States\Workflow
    {
        return $this->active_state;
    }

    /**
     * @param \Botomatic\Engine\Facebook\Abstracts\States\Workflow $active_state
     *
     * @return $this
     */
    public function setActiveState(\Botomatic\Engine\Facebook\Abstracts\States\Workflow $active_state)
    {
        $this->active_state = $active_state;

        return $this;
    }


    /**
     * @param \Botomatic\Engine\Facebook\Abstracts\States\Response\Templates\QuickReplies $quickReplies
     *
     * @return $this
     */
    public function addQuickReplies(\Botomatic\Engine\Facebook\Abstracts\States\Response\Templates\QuickReplies $quickReplies)
    {
        $this->responses[] = [
            'data' => $quickReplies,
            'type' => 'quick_replies',
        ];

        return $this;
    }

    /**
     * @param \Botomatic\Engine\Facebook\Abstracts\States\Response\Templates\Generic $generic
     *
     * @return $this
     */
    public function addGenericTemplate(\Botomatic\Engine\Facebook\Abstracts\States\Response\Templates\Generic $generic)
    {
        $this->responses[] = [
            'data' => $generic,
            'type' => 'generic_template',
        ];
        return $this;
    }

    /**
     * @param \Botomatic\Engine\Facebook\Abstracts\States\Response\Templates\Button $button
     *
     * @return $this
     */
    public function addButtonTemplate(\Botomatic\Engine\Facebook\Abstracts\States\Response\Templates\Button $button)
    {

        $this->responses[] = [
            'data' => $button,
            'type' => 'button_template',
        ];
        return $this;
    }


    /**
     * @param string $message
     *
     * @return $this
     */
    public function addMessage(string $message)
    {
        $this->responses[] = [
            'data' => $message,
            'type' => 'text',
        ];

        return $this;
    }

    /**
     * @param string $image
     *
     * @return $this
     */
    public function addImage($image)
    {
        $this->responses[] = [
            'data' => $image,
            'type' => 'image'
        ];

        return $this;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function askForLocation($title = 'Please share your location:')
    {
        $this->responses[] = [
            'type' => 'location',
            'data' => $title,
        ];

        return $this;
    }

    /**
     * @return bool
     */
    public function isEmpty() : bool
    {
        return count($this->responses) == 0;
    }

    /**
     * @return $this
     */
    public function setStatusFinish()
    {
        $this->status = self::STATUS_FINISH;

        return $this;
    }

    /**
     * @return $this
     */
    public function setStatusActive()
    {
        $this->status = self::STATUS_ACTIVE;

        return $this;
    }

    /**
     * @return $this
     */
    public function setStatusTimeout()
    {
        $this->status = self::STATUS_TIMEOUT;

        return $this;
    }


    /**
     * @return bool
     */
    public function isFinish() : bool
    {
        return $this->status === self::STATUS_FINISH;
    }


    /**
     * @return bool
     */
    public function isActive() : bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * @return bool
     */
    public function isTimeout() : bool
    {
        return $this->status === self::STATUS_TIMEOUT;
    }


    /**
     * @return array
     */
    public function getResponses() : array
    {
        return $this->responses;
    }

    /**
     * @return string
     */
    public function getStatus() : string
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Clear all responses
     */
    public function clearResponses()
    {
        $this->responses = [];
    }

    public function transport()
    {

    }
}

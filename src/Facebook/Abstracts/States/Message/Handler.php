<?php

namespace Botomatic\Engine\Facebook\Abstracts\States\Message;

/**
 * Class Handler
 *
 * Object used to handle the message: detect intent, extract information etc
 *
 * @package Botomatic\Engine\Facebook\Abstracts\States\Message
 */
abstract class Handler
{
    /**
     * @var \Botomatic\Engine\Facebook\Entities\Message
     */
    protected $message;

    /**
     * @param \Botomatic\Engine\Facebook\Entities\Message $message
     */
    public function setMessage(\Botomatic\Engine\Facebook\Entities\Message $message)
    {
        $this->message = $message;
    }

    /**
     * @return \Botomatic\Engine\Facebook\Entities\Message
     */
    public function message() : \Botomatic\Engine\Facebook\Entities\Message
    {
        return $this->message;
    }

}

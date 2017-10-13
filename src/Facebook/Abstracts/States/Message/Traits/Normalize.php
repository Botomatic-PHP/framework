<?php

namespace Botomatic\Engine\Facebook\Abstracts\States\Message\Traits;

/**
 * Class Normalize
 * @package Botomatic\Engine\Facebook\Abstracts\States\Message
 */
trait Normalize
{
    /**
     * @return string
     */
    public function normalizeMessage() : string
    {
        return strtolower($this->message->getMessage());
    }

}

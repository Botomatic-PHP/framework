<?php

namespace Botomatic\Engine\Facebook\Exceptions;

/**
 * Class InvalidConversationKey
 * @package Botomatic\Engine\Facebook\Exceptions
 *
 */
class InvalidConversationKey extends \Exception
{
    /**
     * InvalidConversationKey constructor.
     *
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->message = 'Invalid key "' . $key .'"';
    }
}
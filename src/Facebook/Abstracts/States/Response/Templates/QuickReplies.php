<?php

namespace Botomatic\Engine\Facebook\Abstracts\States\Response\Templates;

/**
 * Class QuickReplies
 * @package Botomatic\Engine\Facebook\Abstracts\States\Response\Templates
 */
abstract class QuickReplies
{
    /**
     * @var string
     */
    public $title = 'Title';

    /**
     * @var array
     */
    public $buttons = [
        [
            'content_type' => 'text',
            'title' => 'Payload',
            'payload' => 'payload',
        ],
    ];

}

<?php

namespace Botomatic\Engine\Facebook\Abstracts\States\Response\Templates;

/**
 * Class Button
 * @package Botomatic\Engine\Facebook\Abstracts\States\Response\Templates
 */
abstract class Button
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
            'type' => 'postback',
            'title' => 'Title',
            'payload' => 'payload',
        ]
    ];
}

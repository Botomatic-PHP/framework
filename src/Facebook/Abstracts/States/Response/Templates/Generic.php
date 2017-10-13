<?php

namespace Botomatic\Engine\Facebook\Abstracts\States\Response\Templates;

/**
 * Class Generic
 * @package Botomatic\Engine\Facebook\Abstracts\States\Response\Templates
 */
abstract class Generic
{

    /**
     * @var array
     */
    public $payloads_templates = [

        [
            'title' => 'Title',
            'subtitle' => 'Subtitle',
            'image_url' => 'image url',
            'buttons' => [
                [
                    'type' => 'postback',
                    'title' => 'Title',
                    'payload' => 'payload',
                ]
            ]
        ],
    ];

}

<?php

namespace Botomatic\Engine\Facebook\Abstracts\States\Response\Templates;

abstract class ListTemplate
{
    /**
     * @var string
     */
    public $top_element_style = 'compact';

    /**
     * @var array
     */
    public $elements = [];

    /**
     * @var array
     */
    public $buttons = [];
}

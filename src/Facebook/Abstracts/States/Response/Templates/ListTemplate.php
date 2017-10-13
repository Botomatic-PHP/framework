<?php

namespace Botomatic\Engine\Facebook\Abstracts\States\Response\Templates;

abstract class ListTemplate
{
    /**
     * @var string
     */
    protected $locale;

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    public function __($string)
    {
        if (isset($string[$this->locale]))
        {
            return $string[$this->locale];
        }
        else
        {
            return $string[env('BOTOMATIC_LOCALE_FALLBACK')];
        }
    }

    /**
     * @var array
     */
    protected $payloads_template = [

        [
            'title' => 'Title',
            'subtitle' => 'Subtit;e',
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

    /**
     * @return array
     */
    public function composeTemplates() : array
    {
        return $this->payloads_template;
    }

}

<?php

namespace Botomatic\Engine\Facebook\Localization\Localizator;

/**
 * Class Factory
 * @package Botomatic\Engine\Facebook\Localization
 */
class Factory
{
    /**
     * @param string $locale
     */
    public static function build(string $locale)
    {
        app()->singleton('botomatic-translator', function () use ($locale) {

            if (env('BOTOMATIC_FACEBOOK_LOCALISATION_SOURCE', 'array') == 'mysql')
            {
                $handler = new Handlers\Mysql();
            }
            else
            {
                $handler = new Handlers\FromArray();
            }
            return new \Botomatic\Engine\Facebook\Localization\Localizator($handler, $locale);
        });
    }

}
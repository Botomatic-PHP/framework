<?php

namespace Botomatic\Engine\Facebook\Localization\Localizator\Handlers;

/**
 * Class Mysql
 * @package Botomatic\Engine\Facebook\Localization\Localizator\Handlers
 */
class Mysql implements ProcessorInterface
{


    /**
     * FromArray constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param string $locale
     * @param string $collection
     * @param string $key
     * @param array $placeholders
     *
     * @return string
     */
    public function make(string $locale, string $collection, string $key, array $placeholders = []): string
    {

    }
}
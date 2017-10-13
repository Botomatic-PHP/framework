<?php

namespace Botomatic\Engine\Facebook\Localization\Localizator\Handlers;

interface ProcessorInterface
{
    /**
     * @param string $locale
     * @param string $collection
     * @param string $key
     * @param array $placeholders
     *
     * @return string
     */
    public function make(string $locale, string $collection, string $key, array $placeholders = []) : string;

}

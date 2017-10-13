<?php

namespace Botomatic\Engine\Facebook\Localization\Localizator\Handlers;

/**
 * Class FromArray
 * @package Botomatic\Engine\Facebook\Localization\Localizator\Handlers
 */
class FromArray implements ProcessorInterface
{
    /**
     * @var array
     */
    protected $data;

    /**
     * FromArray constructor.
     */
    public function __construct()
    {
        $this->data = include app_path(config('botomatic.facebook.conversations'));
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
        if (count($placeholders) == 0)
        {
            return $this->data[$collection]['translations'][$key][$locale];
        }
        else
        {
            $string = $this->data[$collection]['translations'][$key][$locale];

            foreach ($placeholders as $placeholder => $replace_value)
            {
                $string = str_replace(':'.$placeholder, $replace_value, $string);
            }

            return $string;
        }
    }
}
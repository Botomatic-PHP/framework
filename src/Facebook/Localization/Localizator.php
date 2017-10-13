<?php

namespace Botomatic\Engine\Facebook\Localization;

/**
 * Class Localizator
 * @package Botomatic\Engine\Facebook\Localization
 */
class Localizator
{
    /**
     * @var string
     */
    protected $locale;

    /**
     * @var \Botomatic\Engine\Facebook\Localization\Localizator\Handlers\ProcessorInterface
     */
    protected $processor;

    /**
     * Localizator constructor.
     *
     * @param Localizator\Handlers\ProcessorInterface $processor
     * @param string $locale
     */
    public function __construct(Localizator\Handlers\ProcessorInterface $processor, string $locale)
    {
        $this->processor = $processor;
        $this->locale = $locale;
    }

    /**
     * @param string $collection
     * @param string $key
     * @param array $placeholders
     *
     * @return string
     */
    public function translate(string $collection, string $key, array $placeholders = []) : string
    {
        return $this->processor->make($this->locale, $collection, $key, $placeholders);
    }

    /**
     * @param string $locale
     */
    public function setLocale(string $locale)
    {
        $this->locale = $locale;
    }

}
<?php

namespace Botomatic\Engine\Facebook\Entities\Callbacks;

/**
 * Class Referral
 * @package Botomatic\Engine\Facebook\Entities\Callbacks
 */
class Referral
{
    /**
     * @var array
     */
   protected $data = [];

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

}

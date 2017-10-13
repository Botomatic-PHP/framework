<?php

namespace Botomatic\Engine\Facebook\Entities\Callbacks;

/**
 * Class AccountLinking
 * @package Botomatic\Engine\Entities\Platform\Facebook\Callbacks
 */
class AccountLinking
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

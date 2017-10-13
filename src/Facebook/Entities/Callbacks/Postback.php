<?php

namespace Botomatic\Engine\Facebook\Entities\Callbacks;

/**
 * Class Postback
 * @package Botomatic\Engine\Facebook\Entities\Callbacks
 */
class Postback
{

    /**
     * @var string
     */
   protected $payload = '';

   protected $referral = [];

    /**
     * @return string
     */
    public function getPayload(): string
    {
        return $this->payload;
    }

    /**
     * @param string $payload
     */
    public function setPayload(string $payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return array
     */
    public function getReferral(): array
    {
        return $this->referral;
    }

    /**
     * @param array $referral
     */
    public function setReferral(array $referral)
    {
        $this->referral = $referral;
    }

}

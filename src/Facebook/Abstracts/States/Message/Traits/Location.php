<?php

namespace Botomatic\Engine\Facebook\Abstracts\States\Message\Traits;

/**
 * Class Location
 * @package Botomatic\Engine\Facebook\Abstracts\States\Message
 */
trait Location
{
    /**
     * @return bool
     */
    public function hasLocation() : bool
    {
        return $this->message()->hasLocation();
    }

    /**
     * @return \Botomatic\Engine\Core\Entities\Location
     */
    public function getLocation() : \Botomatic\Engine\Core\Entities\Location
    {
        return $this->message()->location();
    }

}

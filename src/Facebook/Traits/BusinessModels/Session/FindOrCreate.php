<?php 

namespace Botomatic\Engine\Facebook\Traits\BusinessModels\Session;

/**
 * Class FindOrCreate
 * @package Botomatic\Engine\Facebook\Traits\BusinessModels\Session
 */
trait FindOrCreate
{
   /**
    * @return  \Botomatic\Engine\Facebook\BusinessModels\Session\FindOrCreate
    */
    protected function facebookBusinessModelSessionFindOrCreate() : \Botomatic\Engine\Facebook\BusinessModels\Session\FindOrCreate
    {
        return \Botomatic\Engine\Services\System\Binder::bind(\Botomatic\Engine\Facebook\BusinessModels\Session\FindOrCreate::class, 'sessionFacebookFindOrCreateBusinessModel');
    }
}





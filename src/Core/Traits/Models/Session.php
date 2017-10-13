<?php

namespace Botomatic\Engine\Core\Traits\Models;

/**
 * Class Session
 * @package Botomatic\Engine\Core\Traits\Models
 */
trait Session
{
    /**
     * @return \Botomatic\Engine\Core\Models\Session
     */
    protected function botomaticModelSession() : \Botomatic\Engine\Core\Models\Session
    {
        return \Botomatic\Engine\Services\System\Binder::bind(\Botomatic\Engine\Core\Models\Session::class, 'botomaticSessionModel');
    }
}
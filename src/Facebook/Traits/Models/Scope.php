<?php

namespace Botomatic\Engine\Facebook\Traits\Models;

/**
 * Class Scope
 * @package Botomatic\Engine\Facebook\Traits\Models
 */
trait Scope
{
    /**
     * @return \Botomatic\Engine\Facebook\Models\Scope
     */
    protected function botomaticFacebookModelScope() : \Botomatic\Engine\Facebook\Models\Scope
    {
        return \Botomatic\Engine\Services\System\Binder::bind(\Botomatic\Engine\Facebook\Models\Scope::class, 'botomaticFacebookScopeModel');
    }
}
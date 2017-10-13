<?php

namespace Botomatic\Engine\Facebook\Entities;

use Botomatic\Engine\Core\Entities\Session;

/**
 * Class Scope
 * @package Botomatic\Engine\Facebook\Entities
 */
class Scope
{
    use \Botomatic\Engine\Core\Traits\Entities\Id;
    use \Botomatic\Engine\Core\Traits\Entities\CreatedAt;
    use \Botomatic\Engine\Core\Traits\Entities\UpdatedAt;

    /**
     * @var \Botomatic\Engine\Core\Entities\Session
     */
    protected $session;

    /**
     * @var \Botomatic\Engine\Facebook\Core\Scope
     */
    protected $scope;

    /**
     * @var \Carbon\Carbon
     */
    protected $timeout = null;

    /**
     * @return Session
     */
    public function getSession(): Session
    {
        return $this->session;
    }

    /**
     * @param \Botomatic\Engine\Core\Entities\Session $session
     */
    public function setSession(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @return \Botomatic\Engine\Facebook\Core\Scope
     */
    public function getScope(): \Botomatic\Engine\Facebook\Core\Scope
    {
        return $this->scope;
    }

    /**
     * @param \Botomatic\Engine\Facebook\Core\Scope $scope
     */
    public function setScope(\Botomatic\Engine\Facebook\Core\Scope $scope)
    {
        $this->scope = $scope;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function getTimeout(): \Carbon\Carbon
    {
        return $this->timeout;
    }

    /**
     * @param \Carbon\Carbon $timeout
     */
    public function setTimeout(\Carbon\Carbon $timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * @return bool
     */
    public function hasTimeout() : bool
    {
        return !is_null($this->timeout);
    }
}
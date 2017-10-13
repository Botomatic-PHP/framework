<?php

namespace Botomatic\Engine\Core\Entities;

/**
 * Class Session
 * @package Botomatic\Engine\Core\Entities
 */
class Session
{
    use \Botomatic\Engine\Core\Traits\Entities\Id;
    use \Botomatic\Engine\Core\Traits\Entities\CreatedAt;
    use \Botomatic\Engine\Core\Traits\Entities\UpdatedAt;
    use \Botomatic\Engine\Core\Traits\Entities\User;

    /**
     * @var string
     */
    protected $session;

    /**
     * @var int
     *
     * @see \Botomatic\Engine\Core\Configuration\Platforms
     */
    protected $platform;

    /**
     * @return string
     */
    public function getSession(): string
    {
        return $this->session;
    }

    /**
     * @param string $session
     */
    public function setSession(string $session)
    {
        $this->session = $session;
    }

    /**
     * @return int
     */
    public function getPlatform(): int
    {
        return $this->platform;
    }

    /**
     * @param int $platform
     */
    public function setPlatform(int $platform)
    {
        $this->platform = $platform;
    }

}
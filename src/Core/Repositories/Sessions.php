<?php

namespace Botomatic\Engine\Core\Repositories;

/**
 * Class Sessions
 * @package Botomatic\Engine\Repositories
 */
class Sessions
{
    /**
     * Models
     */
    use \Botomatic\Engine\Core\Traits\Models\Session;
    use \Botomatic\Engine\Core\Traits\Models\User;

    /**
     * @param string $session
     * @param int $platform
     *
     * @return \Botomatic\Engine\Core\Entities\Session
     */
    public function findBySessionAndPlatform(string $session, int $platform) : \Botomatic\Engine\Core\Entities\Session
    {
        $result = $this->botomaticModelSession()->query()
            ->join($this->botomaticModelUser()->table(), $this->botomaticModelUser()->id, '=', $this->botomaticModelSession()->user_id)
            ->where($this->botomaticModelSession()->session, $session)
            ->where($this->botomaticModelSession()->platform, $platform)
            ->select($this->botomaticModelSession()->composeSelect())
            ->addSelect($this->botomaticModelUser()->composeSelect())
            ->first();

        $entity = $this->botomaticModelSession()->buildEntity($result);

        $entity->setUser($this->botomaticModelUser()->buildEntity($result));

        return $entity;
    }

    /**
     * @param \Botomatic\Engine\Core\Entities\User $user
     *
     * @return \Botomatic\Engine\Core\Entities\Session
     */
    public function findByUser(\Botomatic\Engine\Core\Entities\User $user) : \Botomatic\Engine\Core\Entities\Session
    {
        $result = $this->botomaticModelSession()->query()
            ->where($this->botomaticModelSession()->user_id, $user->getId())
            ->select($this->botomaticModelSession()->composeSelect())
            ->first();

        $entity = $this->botomaticModelSession()->buildEntity($result);

        $entity->setUser($user);

        return $entity;
    }

    /**
     * @param \Botomatic\Engine\Core\Entities\Session $session
     * @return \Botomatic\Engine\Core\Entities\Session
     */
    public function insert(\Botomatic\Engine\Core\Entities\Session $session) : \Botomatic\Engine\Core\Entities\Session
    {
        $id = $this->botomaticModelSession()->insert($this->botomaticModelSession()->buildArrayForInsert($session));

        $session->setId($id);

        return $session;
    }

    /**
     * @param \Botomatic\Engine\Core\Entities\Session $session
     *
     * @return int
     */
    public function delete(\Botomatic\Engine\Core\Entities\Session $session) : int
    {
        return $this->botomaticModelSession()->query()
            ->where($this->botomaticModelSession()->id, $session->getId())
            ->delete();

    }
}
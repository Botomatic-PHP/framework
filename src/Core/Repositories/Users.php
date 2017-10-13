<?php

namespace Botomatic\Engine\Core\Repositories;

/**
 * Class Users
 * @package Botomatic\Engine\Core\Repositories
 */
class Users
{
    /**
     * Models
     */
    use \Botomatic\Engine\Core\Traits\Models\User;

    /**
     * @param int $facebook_id
     *
     * @return \Botomatic\Engine\Core\Entities\User
     */
    public function findByFacebook(int $facebook_id) : \Botomatic\Engine\Core\Entities\User
    {
        $result = $this->botomaticModelUser()->query()
            ->where($this->botomaticModelUser()->facebook_id, $facebook_id)
            ->select($this->botomaticModelUser()->composeSelect())
            ->first();

        return $this->botomaticModelUser()->buildEntity($result);
    }

    /**
     * @param int $id
     *
     * @return \Botomatic\Engine\Core\Entities\User
     */
    public function findById(int $id) : \Botomatic\Engine\Core\Entities\User
    {
        $result = $this->botomaticModelUser()->query()
            ->where($this->botomaticModelUser()->id, $id)
            ->select($this->botomaticModelUser()->composeSelect())
            ->first();

        return $this->botomaticModelUser()->buildEntity($result);
    }

    /**
     * @param \Botomatic\Engine\Core\Entities\User $user
     *
     * @return \Botomatic\Engine\Core\Entities\User
     */
    public function insert(\Botomatic\Engine\Core\Entities\User $user) : \Botomatic\Engine\Core\Entities\User
    {
        $id = $this->botomaticModelUser()->insert(
            $this->botomaticModelUser()->buildArrayForInsert($user)
        );

        $user->setId($id);

        return $user;
    }

    /**
     * @param \Botomatic\Engine\Core\Entities\User $user
     *
     * @return int
     */
    public function delete(\Botomatic\Engine\Core\Entities\User $user) : int
    {
        return $this->botomaticModelUser()->query()
            ->where($this->botomaticModelUser()->id, $user->getId())
            ->delete();
    }

}
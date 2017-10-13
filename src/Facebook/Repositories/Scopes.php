<?php

namespace Botomatic\Engine\Facebook\Repositories;

/**
 * Class Scopes
 * @package Botomatic\Engine\Facebook\Repositories
 */
class Scopes
{
    /**
     * Models
     */
    use \Botomatic\Engine\Facebook\Traits\Models\Scope;
    use \Botomatic\Engine\Core\Traits\Models\Session;
    use \Botomatic\Engine\Core\Traits\Models\User;

    /**
     * @param \Botomatic\Engine\Core\Entities\Session $session
     * @return \Botomatic\Engine\Facebook\Entities\Scope
     */
    public function findBySession(\Botomatic\Engine\Core\Entities\Session $session) : \Botomatic\Engine\Facebook\Entities\Scope
    {
        return $this->botomaticFacebookModelScope()->buildEntity(
            $this->botomaticFacebookModelScope()->query()
                ->where($this->botomaticFacebookModelScope()->session, $session->getId())
                ->select($this->botomaticFacebookModelScope()->composeSelect())
                ->first()
        );
    }

    /**
     * @return \Botomatic\Engine\Facebook\Entities\Scope
     */
    public function findLast() : \Botomatic\Engine\Facebook\Entities\Scope
    {
        return $this->botomaticFacebookModelScope()->buildEntity(
            $this->botomaticFacebookModelScope()->query()
                ->orderBy($this->botomaticFacebookModelScope()->updated_at, 'desc')
                ->select($this->botomaticFacebookModelScope()->composeSelect())
                ->first()
        );
    }

    /**
     * @param \Botomatic\Engine\Facebook\Entities\Scope $scope
     *
     * @return int
     */
    public function update(\Botomatic\Engine\Facebook\Entities\Scope $scope) : int
    {
        return $this->botomaticFacebookModelScope()->query()
            ->where($this->botomaticFacebookModelScope()->id, $scope->getId())
            ->update($this->botomaticFacebookModelScope()->buildArrayForUpdate($scope));
    }

    /**
     * @param \Botomatic\Engine\Facebook\Entities\Scope $scope
     *
     * @return int
     */
    public function insert(\Botomatic\Engine\Facebook\Entities\Scope $scope) : int
    {
        return $this->botomaticFacebookModelScope()
            ->insert($this->botomaticFacebookModelScope()->buildArrayForInsert($scope));
    }


    /**
     * @param \Botomatic\Engine\Core\Entities\Session $session
     *
     * @return int
     */
    public function removeBySession(\Botomatic\Engine\Core\Entities\Session $session) : int
    {
        return $this->botomaticFacebookModelScope()->query()
            ->where($this->botomaticFacebookModelScope()->session, $session->getId())
            ->delete();
    }


    /**
     * @return array
     */
    public function findAllWithSessions() : array
    {
        $results = $this->botomaticFacebookModelScope()->query()

            /*
             * Join sessions table
             */
            ->join($this->botomaticModelSession()->table(), function(\Illuminate\Database\Query\JoinClause $join){

                $join->on($this->botomaticFacebookModelScope()->session, '=', $this->botomaticModelSession()->id);

            })

            /*
             * Join users table
             */
            ->join($this->botomaticModelUser()->table(), function(\Illuminate\Database\Query\JoinClause $join){

                $join->on($this->botomaticModelUser()->id, '=', $this->botomaticModelSession()->user_id);

            })

            ->select($this->botomaticFacebookModelScope()->composeSelect())
            ->addSelect($this->botomaticModelSession()->composeSelect())
            ->addSelect($this->botomaticModelUser()->composeSelect())
            ->get();

            $entities = [];

            foreach ($results as $result)
            {
                $entity = $this->botomaticFacebookModelScope()->buildEntity($result);

                $session = $this->botomaticModelSession()->buildEntity($result);
                $session->setUser($this->botomaticModelUser()->buildEntity($result));

                $entity->setSession($session);

                $entities[] = $entity;
            }

            return $entities;
    }
}
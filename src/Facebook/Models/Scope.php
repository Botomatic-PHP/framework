<?php

namespace Botomatic\Engine\Facebook\Models;

use Botomatic\Engine\Core\Models\Base;

/**
 * Class Scope
 * @package Botomatic\Engine\Facebook\Models
 */
class Scope extends Base
{
    const TABLE = 'botomatic_facebook_scopes';

    const ID = 'id';
    const SESSION = 'session_id';
    const SCOPE = 'scope';

    const TIMEOUT = 'timeout';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    /**
     * @var string
     */
    protected $table = self::TABLE;

    public $id = self::TABLE . '.' . self::ID;

    public $session = self::TABLE . '.' . self::SESSION;
    public $scope = self::TABLE . '.' . self::SCOPE;

    public $timeout = self::TABLE . '.' . self::TIMEOUT;
    public $created_at = self::TABLE . '.' . self::CREATED_AT;
    public $updated_at = self::TABLE . '.' . self::UPDATED_AT;

    /**
     * @var array
     */
    protected $fields = [
        self::ID, self::SESSION, self::SCOPE,
        self::TIMEOUT, self::CREATED_AT, self::UPDATED_AT,
    ];

    /**
     * @param $result
     *
     * @return \Botomatic\Engine\Facebook\Entities\Scope
     */
    public function buildEntity($result) : \Botomatic\Engine\Facebook\Entities\Scope
    {
        $entity = new \Botomatic\Engine\Facebook\Entities\Scope();

        /**
         * If no result
         */
        if (empty($result)) return $entity;

        $entity->setId($result->{$this->id});
        $entity->setScope(unserialize($result->{$this->scope}));

        $entity->setCreatedAt(new \Carbon\Carbon($result->{$this->created_at}));
        $entity->setUpdatedAt(new \Carbon\Carbon($result->{$this->updated_at}));

        return $entity;
    }

    /**
     * @param \Botomatic\Engine\Facebook\Entities\Scope $scope
     *
     * @return array
     */
    public function buildArrayForInsert(\Botomatic\Engine\Facebook\Entities\Scope $scope) : array
    {
        $data = [
            self::SESSION => $scope->getSession()->getId(),
            self::SCOPE => serialize($scope->getScope()),
        ];

        if ($scope->hasTimeout())
        {
            $data[self::TIMEOUT] = $scope->getTimeout();
        }
        else
        {
            $data[self::TIMEOUT] = null;
        }

        return $data;
    }

    /**
     * @param \Botomatic\Engine\Facebook\Entities\Scope $scope
     *
     * @return array
     */
    public function buildArrayForUpdate(\Botomatic\Engine\Facebook\Entities\Scope $scope) : array
    {
        $data = [
            self::SCOPE => serialize($scope->getScope()),
        ];

        if ($scope->hasTimeout())
        {
            $data[self::TIMEOUT] = $scope->getTimeout();
        }
        else
        {
            $data[self::TIMEOUT] = null;
        }

        return $data;
    }
}
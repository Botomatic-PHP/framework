<?php

namespace Botomatic\Engine\Core\Models;

use \Botomatic\Engine\Core\Models\Base;

/**
 * Class Session
 * @package Botomatic\Engine\Core\Models
 */
class Session extends Base
{
    const TABLE = 'botomatic_sessions';

    const ID = 'id';
    const SESSION = 'session';
    const USER_ID = 'user_id';
    const PLATFORM = 'platform'; // \Botomatic\Engine\Core\Configuration\Platforms

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    /**
     * @var string
     */
    protected $table = self::TABLE;

    public $id = self::TABLE . '.' . self::ID;

    public $session = self::TABLE . '.' . self::SESSION;
    public $user_id = self::TABLE . '.' . self::USER_ID;
    public $platform = self::TABLE . '.' . self::PLATFORM;

    public $created_at = self::TABLE . '.' . self::CREATED_AT;
    public $updated_at = self::TABLE . '.' . self::UPDATED_AT;

    /**
     * @var array
     */
    protected $fields = [
        self::ID, self::SESSION, self::USER_ID, self::PLATFORM,
        self::CREATED_AT, self::UPDATED_AT,
    ];

    /**
     * @param $result
     *
     * @return \Botomatic\Engine\Core\Entities\Session
     */
    public function buildEntity($result) : \Botomatic\Engine\Core\Entities\Session
    {
        $entity = new \Botomatic\Engine\Core\Entities\Session();

        /**
         * If no result
         */
        if (empty($result)) return $entity;

        $entity->setId($result->{$this->id});
        $entity->setSession($result->{$this->session});
        $entity->setPlatform($result->{$this->platform});

        $entity->setCreatedAt(new \Carbon\Carbon($result->{$this->created_at}));
        $entity->setUpdatedAt(new \Carbon\Carbon($result->{$this->updated_at}));

        return $entity;
    }

    /**
     * @param \Botomatic\Engine\Core\Entities\Session $session
     *
     * @return array
     */
    public function buildArrayForInsert(\Botomatic\Engine\Core\Entities\Session $session) : array
    {
        return [
            self::SESSION => $session->getSession(),
            self::USER_ID => $session->getUser()->getId(),
            self::PLATFORM => $session->getPlatform(),
        ];
    }
}
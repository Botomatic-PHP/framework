<?php

namespace Botomatic\Engine\Facebook\Models;

use Botomatic\Engine\Core\Models\Base;

/**
 * Class Conversations
 * @package Botomatic\Engine\Facebook\Models
 */
class Conversation extends Base
{
    const TABLE = 'botomatic_facebook_conversations';

    const ID = 'id';
    const COLLECTION = 'collection_id';
    const KEY = 'key';
    const DESCRIPTION = 'description';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    /**
     * @var string
     */
    protected $table = self::TABLE;

    public $id = self::TABLE . '.' . self::ID;
    public $collection = self::TABLE . '.' . self::COLLECTION;
    public $key = self::TABLE . '.' . self::KEY;
    public $description = self::TABLE . '.' . self::DESCRIPTION;

    public $created_at = self::TABLE . '.' . self::CREATED_AT;
    public $updated_at = self::TABLE . '.' . self::UPDATED_AT;

    /**
     * @var array
     */
    protected $fields = [
        self::ID, self::COLLECTION, self::KEY, self::DESCRIPTION,
        self::CREATED_AT, self::UPDATED_AT,
    ];

    /**
     * @param $result
     *
     * @return \Botomatic\Engine\Facebook\Entities\Conversation
     */
    public function buildEntity($result) : \Botomatic\Engine\Facebook\Entities\Conversation
    {
        $entity = new \Botomatic\Engine\Facebook\Entities\Conversation();

        /**
         * If no result
         */
        if (empty($result)) return $entity;

        $entity->setId($result->{$this->id});
        $entity->setKey($result->{$this->key});
        $entity->setDescription($result->{$this->description});

        $entity->setCreatedAt(new \Carbon\Carbon($result->{$this->created_at}));
        $entity->setUpdatedAt(new \Carbon\Carbon($result->{$this->updated_at}));

        return $entity;
    }

    /**
     * @param \Botomatic\Engine\Facebook\Entities\Conversation $conversation
     *
     * @return array
     */
    public function buildArrayForInsert(\Botomatic\Engine\Facebook\Entities\Conversation $conversation) : array
    {
        $data = [
            self::COLLECTION => $conversation->getCollection()->getId(),
            self::KEY => $conversation->getKey(),
            self::DESCRIPTION => $conversation->getDescription(),
        ];

        return $data;
    }

    /**
     * @param \Botomatic\Engine\Facebook\Entities\Conversation $conversation
     *
     * @return array
     */
    public function buildArrayForUpdate(\Botomatic\Engine\Facebook\Entities\Conversation $conversation) : array
    {
        $data = [
            self::KEY => $conversation->getKey(),
            self::DESCRIPTION => $conversation->getDescription(),
        ];

        return $data;
    }
}
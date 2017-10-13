<?php

namespace Botomatic\Engine\Facebook\Models\Conversation;

use Botomatic\Engine\Core\Models\Base;

/**
 * Class Collection
 * @package Botomatic\Engine\Facebook\Models\Conversation
 */
class Collection extends Base
{
    const TABLE = 'botomatic_facebook_conversations_collections';

    const ID = 'id';
    const NAME = 'name';
    const DESCRIPTION = 'description';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    /**
     * @var string
     */
    protected $table = self::TABLE;

    public $id = self::TABLE . '.' . self::ID;

    public $name = self::TABLE . '.' . self::NAME;
    public $description = self::TABLE . '.' . self::DESCRIPTION;

    public $created_at = self::TABLE . '.' . self::CREATED_AT;
    public $updated_at = self::TABLE . '.' . self::UPDATED_AT;

    /**
     * @var array
     */
    protected $fields = [
        self::ID, self::NAME, self::DESCRIPTION,
        self::CREATED_AT, self::UPDATED_AT,
    ];

    /**
     * @param $result
     *
     * @return \Botomatic\Engine\Facebook\Entities\Conversation\Collection
     */
    public function buildEntity($result) : \Botomatic\Engine\Facebook\Entities\Conversation\Collection
    {
        $entity = new \Botomatic\Engine\Facebook\Entities\Conversation\Collection();

        /**
         * If no result
         */
        if (empty($result)) return $entity;

        $entity->setId($result->{$this->id});
        $entity->setName($result->{$this->name});
        $entity->setDescription($result->{$this->description});

        $entity->setCreatedAt(new \Carbon\Carbon($result->{$this->created_at}));
        $entity->setUpdatedAt(new \Carbon\Carbon($result->{$this->updated_at}));

        return $entity;
    }

    /**
     * @param \Botomatic\Engine\Facebook\Entities\Conversation\Collection $category
     *
     * @return array
     */
    public function buildArrayForInsert(\Botomatic\Engine\Facebook\Entities\Conversation\Collection $category) : array
    {
        $data = [
            self::NAME => $category->getName(),
            self::DESCRIPTION => $category->getDescription(),
        ];

        return $data;
    }

    /**
     * @param \Botomatic\Engine\Facebook\Entities\Conversation\Collection $category
     *
     * @return array
     */
    public function buildArrayForUpdate(\Botomatic\Engine\Facebook\Entities\Conversation\Collection $category) : array
    {
        $data = [
            self::NAME => $category->getName(),
            self::DESCRIPTION => $category->getDescription(),
        ];

        return $data;
    }
}
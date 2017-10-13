<?php

namespace Botomatic\Engine\Facebook\Models\Conversation;

use Botomatic\Engine\Core\Models\Base;

/**
 * Class Locale
 * @package Botomatic\Engine\Facebook\Models
 */
class Locale extends Base
{
    const TABLE = 'botomatic_facebook_conversations_locales';

    const ID = 'id';
    const CONVERSATION_ID = 'conversation_id';
    const LOCALE = 'locale';
    const TEXT = 'text';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    /**
     * @var string
     */
    protected $table = self::TABLE;

    public $id = self::TABLE . '.' . self::ID;
    public $conversation_id = self::TABLE . '.' . self::CONVERSATION_ID;
    public $locale = self::TABLE . '.' . self::LOCALE;
    public $text = self::TABLE . '.' . self::TEXT;

    public $created_at = self::TABLE . '.' . self::CREATED_AT;
    public $updated_at = self::TABLE . '.' . self::UPDATED_AT;

    /**
     * @var array
     */
    protected $fields = [
        self::ID, self::CONVERSATION_ID, self::LOCALE, self::TEXT,
        self::CREATED_AT, self::UPDATED_AT,
    ];

    /**
     * @param $result
     *
     * @return \Botomatic\Engine\Facebook\Entities\Conversation\Locale
     */
    public function buildEntity($result) : \Botomatic\Engine\Facebook\Entities\Conversation\Locale
    {
        $entity = new \Botomatic\Engine\Facebook\Entities\Conversation\Locale();

        /**
         * If no result
         */
        if (empty($result)) return $entity;

        $entity->setId($result->{$this->id});
        $entity->setLocale($result->{$this->locale});
        $entity->setText($result->{$this->text});

        $entity->setCreatedAt(new \Carbon\Carbon($result->{$this->created_at}));
        $entity->setUpdatedAt(new \Carbon\Carbon($result->{$this->updated_at}));

        return $entity;
    }

    /**
     * @param \Botomatic\Engine\Facebook\Entities\Conversation\Locale $conversation
     *
     * @return array
     */
    public function buildArrayForInsert(\Botomatic\Engine\Facebook\Entities\Conversation\Locale $conversation) : array
    {
        $data = [
            self::CONVERSATION_ID => $conversation->getConversation()->getId(),
            self::LOCALE => $conversation->getLocale(),
            self::TEXT => $conversation->getText(),
        ];

        return $data;
    }

    /**
     * @param \Botomatic\Engine\Facebook\Entities\Conversation\Locale $conversation
     *
     * @return array
     */
    public function buildArrayForUpdate(\Botomatic\Engine\Facebook\Entities\Conversation\Locale $conversation) : array
    {
        $data = [
            self::TEXT => $conversation->getText(),
        ];

        return $data;
    }
}
<?php

namespace Botomatic\Engine\Facebook\Entities;


/**
 * Class Conversation
 * @package Botomatic\Engine\Facebook\Entities
 */
class Conversation
{
    use \Botomatic\Engine\Core\Traits\Entities\Id;
    use \Botomatic\Engine\Core\Traits\Entities\CreatedAt;
    use \Botomatic\Engine\Core\Traits\Entities\UpdatedAt;

    /**
     * @var \Botomatic\Engine\Facebook\Entities\Conversation\Collection
     */
    protected $collection;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $description;


    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return Conversation\Collection
     */
    public function getCollection(): Conversation\Collection
    {
        return $this->collection;
    }

    /**
     * @param Conversation\Collection $collection
     */
    public function setCollection(Conversation\Collection $collection)
    {
        $this->collection = $collection;
    }
}
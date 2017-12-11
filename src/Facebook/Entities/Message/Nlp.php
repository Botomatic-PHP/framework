<?php

namespace Botomatic\Engine\Facebook\Entities\Message;

/**
 * Class Nlp
 * @package Botomatic\Engine\Facebook\Entities\Message
 */
class Nlp
{
    /**
     * @var array
     */
    protected $entities;

    /**
     * @return array
     */
    public function getEntities() : array
    {
        return $this->entities;
    }

    /**
     * @param array $entities
     */
    public function setEntities(array $entities): void
    {
        $this->entities = $entities;
    }

    /**
     * @param string $entity
     * @return array
     */
    public function getEntity(string $entity) : array
    {
        if ($this->entityExists($entity))
        {
            return $this->entities[$entity];
        }

        return [];
    }

    /**
     * @param string $entity
     * @return bool
     */
    public function entityExists(string $entity) : bool
    {
        return isset($this->entities[$entity]);
    }
}

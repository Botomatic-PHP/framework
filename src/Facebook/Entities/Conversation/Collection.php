<?php

namespace Botomatic\Engine\Facebook\Entities\Conversation;

/**
 * Class Collection
 * @package Botomatic\Engine\Facebook\Entities\Conversation
 */
class Collection
{
    use \Botomatic\Engine\Core\Traits\Entities\Id;
    use \Botomatic\Engine\Core\Traits\Entities\CreatedAt;
    use \Botomatic\Engine\Core\Traits\Entities\UpdatedAt;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
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

}
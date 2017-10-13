<?php

namespace Botomatic\Engine\Facebook\Repositories;

/**
 * Class Conversations
 * @package Botomatic\Engine\Facebook\Repositories
 */
class Conversations
{
    /**
     * Models
     */
    use \Botomatic\Engine\Facebook\Traits\Models\Conversation;

    public function findByKey(string $key) : \Botomatic\Engine\Facebook\Entities\Conversation
    {
        $this->botomaticFacebookModelConversation()->buildEntity(
            $this->botomaticFacebookModelConversation()->query()
                ->where($this->botomaticFacebookModelConversation()->key, $key)
                ->select($this->botomaticFacebookModelConversation()->composeSelect())
                ->first()
        );
    }
}
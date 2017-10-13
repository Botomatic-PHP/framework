<?php

namespace Botomatic\Engine\Facebook\Entities\Conversation;

/**
 * Class Locale
 * @package Botomatic\Engine\Facebook\Entities\Conversation
 */
class Locale
{
    use \Botomatic\Engine\Core\Traits\Entities\Id;
    use \Botomatic\Engine\Core\Traits\Entities\CreatedAt;
    use \Botomatic\Engine\Core\Traits\Entities\UpdatedAt;

    /**
     * @var \Botomatic\Engine\Facebook\Entities\Conversation
     */
    protected $conversation;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var string
     */
    protected $text;

    /**
     * @return \Botomatic\Engine\Facebook\Entities\Conversation
     */
    public function getConversation(): \Botomatic\Engine\Facebook\Entities\Conversation
    {
        return $this->conversation;
    }

    /**
     * @param \Botomatic\Engine\Facebook\Entities\Conversation $conversation
     */
    public function setConversation(\Botomatic\Engine\Facebook\Entities\Conversation $conversation)
    {
        $this->conversation = $conversation;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale(string $locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text)
    {
        $this->text = $text;
    }

}
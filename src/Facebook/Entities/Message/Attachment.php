<?php

namespace Botomatic\Engine\Facebook\Entities\Message;

/**
 * Class Attachment
 * @package Botomatic\Engine\Facebook\Entities\Message
 */
class Attachment
{

    /**
     * @var string
     */
    protected $type;

    /**
     * @var
     */
    protected $url;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

}

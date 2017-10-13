<?php

namespace Botomatic\Engine\Facebook\Abstracts\States\Response;

/**
 * Class Handler
 * @package Botomatic\Engine\Facebook\Abstracts\States\Response
 */
abstract class Handler
{
    /**
     * @var \Botomatic\Engine\Facebook\Entities\Response
     */
    protected $response;

    /**
     * @param \Botomatic\Engine\Facebook\Entities\Response $response
     */
    public function setResponse(\Botomatic\Engine\Facebook\Entities\Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return \Botomatic\Engine\Facebook\Entities\Response
     */
    public function response() : \Botomatic\Engine\Facebook\Entities\Response
    {
        return $this->response;
    }
}

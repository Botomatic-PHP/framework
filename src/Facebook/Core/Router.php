<?php

namespace Botomatic\Engine\Facebook\Core;

/**
 * Class Router
 * @package Botomatic\Engine\Facebook\Core
 */
class Router
{
    /**
     * @var string
     */
    protected $listener;

    /**
     * @var array
     */
    protected $filters = [

    ];

    /**
     * @var array
     */
    protected $workflow = [

    ];

    /**
     * @var array
     */
    protected $postback = [

    ];

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->listener = \App\Bot\Facebook\States\Listener\Listener::class;

        $this->filters = include app_path('Bot/Facebook/Routes/Filters.php');
        $this->postback = include app_path('Bot/Facebook/Routes/Postbacks.php');
        $this->workflow = include app_path('Bot/Facebook/Routes/Workflow.php');
    }


    /**
     * @param \Botomatic\Engine\Facebook\Abstracts\States\Workflow $state
     * @param \Botomatic\Engine\Facebook\Entities\Response $response
     *
     * @return \Botomatic\Engine\Facebook\Abstracts\States\Workflow
     *
     * @throws \Botomatic\Engine\Platforms\Facebook\Exceptions\State\InvalidStateRouting
     */
    public function getNextState(\Botomatic\Engine\Facebook\Abstracts\States\Workflow $state, \Botomatic\Engine\Facebook\Entities\Response $response) : \Botomatic\Engine\Facebook\Abstracts\States\Workflow
    {
        try
        {
            $next_state = $this->workflow[$state->getSignature()][$response->getStatus()];

            return new $next_state();
        }
        catch (\Exception $exception)
        {

            // the bot should never fail
            return new \App\Bot\Facebook\States\Fallback\Fallback();
        }}

    /**
     * @return \Botomatic\Engine\Facebook\Abstracts\States\Workflow
     */
    public function getListener() : \Botomatic\Engine\Facebook\Abstracts\States\Workflow
    {
        return new $this->listener();
    }

    /**
     * @return array
     */
    public function getFilters() : array
    {
        return $this->filters;
    }

    /**
     * @return array
     */
    public function getPostbacks() : array
    {
        return $this->postback;
    }
}
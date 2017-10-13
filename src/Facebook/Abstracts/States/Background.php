<?php

namespace Botomatic\Engine\Facebook\Abstracts\States;

abstract class Background
{

    /**
     * @var \Botomatic\Engine\Core\Entities\Session
     */
    protected $session;

    /**
     * @param \Botomatic\Engine\Core\Entities\Session $session
     *
     * @return \Botomatic\Engine\Facebook\Entities\Response
     *
     * @throws \Botomatic\Engine\Platforms\Facebook\Exceptions\State\MessageHandlerMissing
     */
    public function handle(\Botomatic\Engine\Core\Entities\Session $session) : \Botomatic\Engine\Facebook\Entities\Response
    {
        $this->session = $session;
    }


    /*------------------------------------------------------------------------------------------------------------------
     *
     *
     * Methods needed to be defined by the state
     *
     *
     -----------------------------------------------------------------------------------------------------------------*/

    /**
     * The state which will be triggered
     *
     * @return Workflow
     */
    protected abstract function state() : \Botomatic\Engine\Facebook\Abstracts\States\Workflow;




    /*------------------------------------------------------------------------------------------------------------------
     *
     *
     * State object specific
     *
     *
     -----------------------------------------------------------------------------------------------------------------*/
    /**
     * @return string
     */
    public function getSignature() : string
    {
        return static::class;
    }
}

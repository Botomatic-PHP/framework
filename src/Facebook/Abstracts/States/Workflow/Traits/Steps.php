<?php

namespace Botomatic\Engine\Facebook\Abstracts\States\Workflow\Traits;

/**
 * Class Steps
 *
 * $this->step must be serialized
 *
 * @package Botomatic\Engine\Facebook\Abstracts\States\Workflow\Traits
 */
trait Steps
{
    /**
     * @var int
     */
    protected $step = 0;

    /**
     * @param null|int $step
     */
    protected function nextStep($step = null)
    {
        if (is_null($step))
        {
            $this->step++;
        }
        else
        {
            $this->step = $step;
        }
    }

    /**
     * @return bool
     */
    protected function isFirstStep() : bool
    {
        return $this->step == 0;
    }

    /**
     * @return bool
     */
    protected function isSecondStep() : bool
    {
        return $this->step == 1;
    }

    /**
     * @return bool
     */
    protected function isThirdStep() : bool
    {
        return $this->step == 2;
    }

    /**
     * @param mixed $step
     *
     * @return bool
     */
    protected function isStep($step) : bool
    {
        return $this->step == $step;
    }

    /**
     * @return void
     */
    protected function resetSteps()
    {
        $this->step = 0;
    }
}

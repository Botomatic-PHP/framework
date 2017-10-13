<?php

namespace Botomatic\Engine\Facebook\Console\Abstracts;

use Illuminate\Console\Command;

abstract class Background extends Command
{

    /**
     * Repositories
     */
    use \Botomatic\Engine\Facebook\Traits\Repositories\Scopes;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';


    /**
     * @param \Botomatic\Engine\Facebook\Entities\Scope $scope
     *
     * @return mixed
     */
    protected abstract function process(\Botomatic\Engine\Facebook\Entities\Scope $scope);

    /**
     * Execute the console command.
     *
     * todo: execute in chunks
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function handle()
    {
        /** @var \Botomatic\Engine\Facebook\Entities\Scope$scope */
        foreach ($this->getActiveScopes() as $scope)
        {
            $result = $this->process($scope);

            /*----------------------------------------------------------------------------------------------------------
             *
             *
             * Check the response of the state, either it has a response that we dispatch to facebook, jumps to another
             * state or just null at which point we ignore and move on
             *
             *
             ---------------------------------------------------------------------------------------------------------*/
            if ($result instanceof \Botomatic\Engine\Facebook\Entities\Response)
            {
                // locally we output the responses
                if (app()->isLocal())
                {
                    var_dump($result->getResponses());
                }
                else
                {
                    $this->dispatchResponse($result, $scope->getSession());
                }

            }
            /*----------------------------------------------------------------------------------------------------------
             *
             *
             * Switch the scope to a new state, process and save
             *
             *
             ---------------------------------------------------------------------------------------------------------*/
            elseif ($result instanceof \Botomatic\Engine\Facebook\Abstracts\States\Workflow)
            {
                // get scope object
                $scope_object = $scope->getScope();

                // set the new active state
                $scope_object->setActiveState($result);

                // compose an empty message for the scope
                $message = new \Botomatic\Engine\Facebook\Entities\Message();

                /*------------------------------------------------------------------------------------------------------
                 *
                 *
                 * Process the new state
                 *
                 *
                 -----------------------------------------------------------------------------------------------------*/
                $response = $scope_object->handleMessage($message, $scope->getSession());


                /*------------------------------------------------------------------------------------------------------
                 *
                 *
                 * Dispatch response
                 *
                 *
                 -----------------------------------------------------------------------------------------------------*/
                if (!app()->isLocal())
                {
                    /**
                     * Send response to facebook
                     */
                     $this->dispatchResponse($response, $scope->getSession());
                }
                else
                {
                    /**
                     * Return response for output
                     */
                    var_dump($response->getResponses());
                }

                /*------------------------------------------------------------------------------------------------------
                 *
                 *
                 * Save state/scope
                 *
                 *
                 -----------------------------------------------------------------------------------------------------*/
                $scope->setScope($scope_object);

                $this->botomaticFacebookRepositoryScopes()->update($scope);

            }
            else
            {
                continue;
            }
        }
    }



    /**
     * Get all scopes to which to send a message.
     *
     * Method to be rewritten to select specific scopes only
     *
     * @return array
     */
    protected function getActiveScopes() : array
    {
        return $this->botomaticFacebookRepositoryScopes()->findAllWithSessions();
    }

    /**
     * @return \Botomatic\Engine\Facebook\Entities\Response
     */
    protected function respond() : \Botomatic\Engine\Facebook\Entities\Response
    {
        return new \Botomatic\Engine\Facebook\Entities\Response();
    }

    /**
     * @param \Botomatic\Engine\Facebook\Abstracts\States\Workflow $workflowState
     *
     * @return \Botomatic\Engine\Facebook\Abstracts\States\Workflow
     */
    protected function jumpToState(\Botomatic\Engine\Facebook\Abstracts\States\Workflow $workflowState) : \Botomatic\Engine\Facebook\Abstracts\States\Workflow
    {
        return $workflowState;
    }

    /**
     * todo: start a job
     *
     * @param \Botomatic\Engine\Facebook\Entities\Response $response
     * @param \Botomatic\Engine\Core\Entities\Session $session
     */
    private function dispatchResponse(\Botomatic\Engine\Facebook\Entities\Response $response, \Botomatic\Engine\Core\Entities\Session $session)
    {
        $facebook_dispatcher = new \Botomatic\Engine\Facebook\Core\Dispatcher($session);

        $facebook_dispatcher->sendResponse($response, $session);
    }
}

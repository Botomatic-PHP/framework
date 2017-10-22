<?php echo "<?php \n" ?>

namespace {{ $namespace }};

/**
 * Class {{ $object }}
 * @package {{ $namespace }}
 */
class {{ $object }} extends \Botomatic\Engine\Facebook\Console\Abstracts\Background
{
    /**
     * @var string
     */
    protected $signature = 'facebook:background';

    /**
     * @param \Botomatic\Engine\Facebook\Entities\Scope $scope
     *
     * @return \Botomatic\Engine\Facebook\Entities\Response|\Botomatic\Engine\Facebook\Abstracts\States\Workflow|null
     */
    protected function process(\Botomatic\Engine\Facebook\Entities\Scope $scope)
    {
        /**
         * Response that is dispatched to facebook
         */
         // return $this->respond()->addMessage('Hey there!');


        /**
         * Response that moves the scope to a new state
         */
        // return $this->jumpToState();
    }

}
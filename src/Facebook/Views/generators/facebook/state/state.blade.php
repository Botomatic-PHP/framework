<?php echo "<?php \n" ?>

namespace {{ $namespace }};

/**
 * Class {{ $object }}
 * @package {{ $namespace }}
 */
class {{ $object }} extends \Botomatic\Engine\Facebook\Abstracts\States\Workflow
{

    /**
     * @var \{{ $response_handler }}
     */
    protected $response;

    /**
     * @var \{{ $message_handler }}
     */
    protected $message;

    /**
     * Logic specific to the state
     *
     * @return \Botomatic\Engine\Facebook\Entities\Response
     */
    protected function process(): \Botomatic\Engine\Facebook\Entities\Response
    {
        return $this->response->responseDefault();
    }
}
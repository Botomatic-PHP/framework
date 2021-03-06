<?php echo "<?php \n" ?>

namespace {{ $namespace }};

use \Botomatic\Engine\Facebook\Entities\Response;
use \Botomatic\Engine\Facebook\Abstracts\States\Workflow\Traits;

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
    protected function process() : Response
    {
        return $this->response->responseDefault();
    }
}
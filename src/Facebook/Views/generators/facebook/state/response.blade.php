<?php echo "<?php \n" ?>

namespace {{ $namespace }};

use \Botomatic\Engine\Facebook\Entities\Response;

/**
 * Class Responses
 * @package {{ $namespace }}
 */
class Responses extends \Botomatic\Engine\Facebook\Abstracts\States\Response\Handler
{
    /**
     * @return \Botomatic\Engine\Facebook\Entities\Response
     */
    public function responseDefault() : Response
    {
          return $this->response->addMessage('This is the default message')
              ->setStatusActive()
              ->sendResponse();
    }
}

<?php echo "<?php \n" ?>

namespace {{ $namespace }};

/**
 * Class Responses
 * @package {{ $namespace }}
 */
class Responses extends \Botomatic\Engine\Facebook\Abstracts\States\Response\Handler
{

  /**
   * @return \Botomatic\Engine\Facebook\Entities\Response
   */
  public function responseDefault() : \Botomatic\Engine\Facebook\Entities\Response
  {
      return $this->response->addMessage('This is the default message')
        ->setStatusActive()
        ->respond();
  }

}

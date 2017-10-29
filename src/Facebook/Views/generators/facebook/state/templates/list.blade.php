<?php echo "<?php \n" ?>

namespace {{ $namespace }};

/**
 * Class {{ $object }}
 * @package {{ $namespace }}
 */
class {{ $object }} extends \Botomatic\Engine\Facebook\Abstracts\States\Response\Templates\ListTemplate
{
    /**
     * Options: large, compact
     *
     * @var string
     */
    public $top_element_style = 'compact';

    /**
     * @var array
     */
    public $elements = [];

    /**
     * @var array
     */
    public $buttons = [];
}
<?php echo "<?php \n" ?>

namespace {{ $namespace }};

/**
 * Class {{ $object }}
 * @package {{ $namespace }}
 */
class {{ $object }} extends \Botomatic\Engine\Facebook\Abstracts\States\Response\Templates\Button
{
    /**
     * @var string
     */
    public $title = 'Title';

    /**
     * @var array
     */
    public $buttons = [
        [
            'type' => 'postback',
            'title' => 'Title',
            'payload' => 'payload',
        ]
    ];
}


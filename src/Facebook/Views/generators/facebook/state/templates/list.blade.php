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
    public $top_element_style = 'compact';

    /**
     * @var string
     */
     public $title = 'Title';

    /**
     * @var string
     */
     public $subtitle = 'Subtitle';

    /**
     * @var string
     */
     public $image_url = 'http://some.url/image';

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
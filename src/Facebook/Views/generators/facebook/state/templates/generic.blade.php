<?php echo "<?php \n" ?>

namespace {{ $namespace }};

/**
 * Class {{ $object }}
 * @package {{ $namespace }}
 */
class {{ $object }} extends \Botomatic\Engine\Facebook\Abstracts\States\Response\Templates\Generic
{

    /**
     * @var array
     */
    public $payloads_template = [

        [
            'title' => 'Title',
            'subtitle' => 'Subtitle',
            'image_url' => 'image url',
            'buttons' => [
                [
                    'type' => 'postback',
                    'title' => 'Title',
                    'payload' => 'payload',
                ]
            ]
        ],
    ];

}
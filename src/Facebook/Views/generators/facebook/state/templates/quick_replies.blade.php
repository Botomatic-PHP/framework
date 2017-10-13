<?php echo "<?php \n" ?>

namespace {{ $namespace }};
/**
 * Class {{ $object }}
 * @package {{ $namespace }}
 */
class {{ $object }} extends \Botomatic\Engine\Facebook\Abstracts\States\Response\Templates\QuickReplies
{
    /**
     * @param string $title
     */
    public function __construct(string $title)
    {
        $this->title = $title;

        $this->buttons = [
            [
                'content_type' => 'text',
                'title' => 'Payload',
                'payload' => 'payload',
            ],
        ];
    }

}

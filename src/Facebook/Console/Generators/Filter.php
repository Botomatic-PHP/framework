<?php

namespace Botomatic\Engine\Facebook\Console\Generators;

use Illuminate\Console\Command;

/**
 * Class Filter
 * @package Botomatic\Engine\Facebook\Console\Generators
 */
class Filter extends \Botomatic\Engine\Facebook\Console\BotomaticCommands
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bf:filter {namespace} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new filter';

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var string
     */
    protected $location;

    /**
     * State constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->namespace = 'App\Bot\Facebook';
        $this->location = app_path('Bot/Facebook');
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        /**
         * Data from user
         */
        $state_name = ucfirst($this->argument('name'));
        $state_group = ucfirst($this->argument('namespace'));

        $namespace = $this->namespace  . '\\States\\Filters\\' . str_replace('/', '\\', $state_group) . '\\' . $state_name ;

        /**
         * Ask for confirmation
         */
        $this->print_botomatic();

        $this->comment($namespace);

        if (!$this->confirm('Are you sure? any existing state will be overwritten', 'yes')) return;

        /**
         * Directories
         */
        $directory_path_group = $this->location . '/States/Filters/' . $state_group;
        $directory_path = $directory_path_group .'/'. $state_name;

        /**
         * Variables needed for the state object
         */
        $state_data = [
            'namespace' => $namespace,
            'message_handler' => $namespace . '\\Handlers\Message',
            'response_handler' => $namespace . '\\Handlers\Responses',
            'object' => $state_name,
        ];

        /**
         * Filter folder
         */
        if (!is_dir($directory_path))
        {
            mkdir($directory_path,0777, true);
        }

        file_put_contents($directory_path. '/' . $state_name . '.php',
            view('botomatic::generators.facebook.state.filter.state', $state_data)->render()
        );

        /**
         * Message handler
         */
        if (!is_dir($directory_path . '/Handlers'))
        {
            mkdir($directory_path . '/Handlers');
        }

        $state_message_data = [
            'namespace' => $namespace . '\\Handlers',
        ];

        file_put_contents($directory_path . '/Handlers/Message.php',
            view('botomatic::generators.facebook.state.filter.message', $state_message_data)->render()
        );

        /**
         * Response handler
         */
        file_put_contents($directory_path . '/Handlers/Responses.php',
            view('botomatic::generators.facebook.state.filter.response', $state_message_data)->render()
        );

        $this->info('Filter created successfully, remember to add it Routes/Filter or Postbacks');

        $this->info('\\' . $namespace . '\\' . $state_name . '::class');
    }
}

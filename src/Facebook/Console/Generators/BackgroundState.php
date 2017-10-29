<?php

namespace Botomatic\Engine\Facebook\Console\Generators;

/**
 * Class BackgroundState
 * @package Botomatic\Engine\Facebook\Console\Generators
 */
class BackgroundState extends \Botomatic\Engine\Core\Console\BotomaticCommands
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:background {namespace} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new  background state';

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

        $namespace = $this->namespace  . '\\States\\Background\\' . str_replace('/', '\\', $state_group);


        /**
         * Ask for confirmation
         */
        $this->print_botomatic();

        $this->comment($namespace);

        if (!$this->confirm('Create new background state? any existing state will be overwritten', 'yes')) return;


        /**
         * Directories
         */
        $directory_path = $this->location . '/States/Background/' . $state_group;


        /**
         * Variables needed for the state object
         */
        $state_data = [
            'namespace' => $namespace,
            'object' => $state_name,
        ];


        /**
         * State folder
         */
        if (!is_dir($directory_path))
        {
            mkdir($directory_path, 0777, true);
        }

        file_put_contents($directory_path. '/' . $state_name . '.php',
            view('botomatic::generators.facebook.state.background', $state_data)->render()
        );

        $this->info('State created successfully. Remember that this state is a console command.');
    }
}

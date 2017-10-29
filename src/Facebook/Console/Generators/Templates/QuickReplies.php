<?php

namespace Botomatic\Engine\Facebook\Console\Generators\Templates;

/**
 * Class QuickReplies
 * @package Botomatic\Engine\Facebook\Console\Generators\Templates
 */
class QuickReplies extends \Botomatic\Engine\Core\Console\BotomaticCommands
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:quick-reply {namespace} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new quick reply template';

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

        $this->print_botomatic();

        /**
         * Data from user
         */
        $template_name = ucfirst($this->argument('name'));
        $template_group = ucfirst($this->argument('namespace'));

        $namespace = $this->namespace  . '\\Templates\\QuickReplies\\' . str_replace('/', '\\', $template_group);


        $this->info('\\' . $namespace . '\\' . $template_name . '::class');
        if (!$this->confirm('Create new quick reply template? any existing template will be overwritten', 'yes')) return;


        $directory_path = $this->location . '/Templates/QuickReplies/' . $template_group;

        /**
         * Variables needed for the state object
         */
        $state_data = [
            'namespace' => $namespace,
            'object' => $template_name,
        ];

        if (!is_dir($directory_path))
        {
            mkdir($directory_path, 0777, true);
        }

        file_put_contents($directory_path. '/' . $template_name . '.php',
            view('botomatic::generators.facebook.state.templates.quick_replies', $state_data)->render()
        );

        $this->info('Template created successfully.');

    }
}

<?php

namespace Botomatic\Engine\Core\Console;

use Illuminate\Console\Command;

class Help extends BotomaticCommands
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'botomatic:help';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Help';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Botomatic v.' . BOTOMATIC_VERSION);
    }
}

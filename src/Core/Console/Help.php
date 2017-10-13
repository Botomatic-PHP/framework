<?php

namespace Botomatic\Engine\Core\Console;

use Illuminate\Console\Command;

class Help extends Command
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
        $this->info('Botomatic v.1.0.1');

        $this->info("\n");

        $this->info('-------- Available Commands --------');

        $this->info("\n");

        $this->info('---- Generators --------');

        $this->info("\n");

        $this->comment('[1] New state: facebook:state {group} {name}');
        $this->comment('[2] New filter: facebook:filter {group} {name}');

    }
}

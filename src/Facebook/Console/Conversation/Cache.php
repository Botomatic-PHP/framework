<?php

namespace Botomatic\Engine\Facebook\Console;

use Illuminate\Console\Command;

/**
 * Class Cache
 * @package Botomatic\Engine\Facebook\Console
 */
class Cache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bf:conversation --cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache all conversations';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        try
        {


        }
        catch (\Exception $e)
        {
            $this->error($e->getMessage());
        }
    }

}

<?php

namespace Botomatic\Engine\Core\Console;

use Illuminate\Console\Command;

/**
 * Class BotomaticCommands
 * @package Botomatic\Engine\Facebook\Console
 *
 * Base for all console commands
 */
class BotomaticCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Botomatic command';

    /**
     *
     */
    protected function print_botomatic()
    {
        $botomatic = "-------------------------------------\n";

        $botomatic .= "
         _ __                              
( /  )   _/_                _/_o   
 /--< __ /  __ _ _ _   __,  / ,  _,
/___/(_)(__(_)/ / / /_(_/(_(__(_(__ 
        \n";

        $botomatic .= "-------------------------------------\n";


        $this->comment($botomatic);

    }

}

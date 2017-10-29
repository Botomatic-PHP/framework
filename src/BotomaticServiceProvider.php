<?php

namespace Botomatic\Engine;

use Illuminate\Support\ServiceProvider;

class BotomaticServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Include routes file
         */
        $this->loadRoutesFrom(__DIR__ . '/Includes/routes.php');

        /**
         * Publish configuration files
         */
        $this->publishes([
            __DIR__.'/Includes/config/facebook.php' => config_path('botomatic/facebook.php'),
        ]);

        /**
         * Load Migrations
         */
        $this->loadMigrationsFrom(__DIR__.'/Includes/migrations');

        /**
         * Load Views
         */
        $this->loadViewsFrom(__DIR__.'/Facebook/Views', 'botomatic');

        /**
         * Load commands
         */
        if ($this->app->runningInConsole())
        {
            $this->commands([

                /**
                 * Core
                 */
                Core\Console\Help::class,

                /**
                 * Setup
                 */
                Facebook\Console\SetupProfile::class,

                /**
                 * Generators
                 */
                Facebook\Console\Generators\State::class,
                Facebook\Console\Generators\Filter::class,
                Facebook\Console\Generators\BackgroundState::class,
                Facebook\Console\Generators\Templates\QuickReplies::class,
                Facebook\Console\Generators\Templates\GenericTemplates::class,
                Facebook\Console\Generators\Templates\ButtonTemplates::class,
                Facebook\Console\Generators\Templates\ListTemplates::class,

                /**
                 * Facebook commands
                 */

                // cli bot
                Facebook\Console\Develop\CliBot::class,
            ]);
        }

        /**
         * Load helpers
         */
        require_once __DIR__. '/Includes/helpers.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

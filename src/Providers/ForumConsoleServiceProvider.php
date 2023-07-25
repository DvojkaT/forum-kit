<?php

namespace DvojkaT\Forumkit\Providers;

use DvojkaT\Forumkit\Console\Commands\InstallCommand;
use Illuminate\Support\ServiceProvider;

class ForumConsoleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
    }
}

<?php

declare(strict_types=1);

namespace DeSmart\Laravel\Enumeration;

use DeSmart\Laravel\Enumeration\Console\MakeEnumCommand;
use Illuminate\Support\ServiceProvider;

class EnumerationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands(MakeEnumCommand::class);
        }
    }
}
<?php

namespace Traffordfewster\AccessCode;

use Illuminate\Support\ServiceProvider;

class AccessCodeServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }
}

<?php

namespace Websanova\Novasize\Providers;

use Illuminate\Support\ServiceProvider;

class NovasizeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            'Websanova\Novasize\Console\Novasize'
        ]);
    }

    public function boot()
    {

    }
}

<?php

namespace BenComeau\ArtisanMakeView;

use Illuminate\Support\ServiceProvider;

class ArtisanMakeViewServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(ViewMakeCommand::class);
    }
}
<?php

namespace ElfSundae\Laravel\AssetVersion;

use Illuminate\Support\ServiceProvider;

class AssetVersionServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\AssetVersionUpdateCommand::class,
            ]);
        }
    }
}

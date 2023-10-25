<?php

namespace TtenSrl\ArchiverLite;

use TtenSrl\ArchiverLite\Http\Livewire\Archiver;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class ArchiverLiteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/bricks-archiver-lite.php', 'bricks-archiver-lite'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'bricks-archiver-lite');
        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'bricks-archiver-lite');
        $this->publishingFile();
        $this->registerBladeComponent();
    }

    /**
     * File che possono esssere pubblicati fuori dal Package
     */
    public function publishingFile()
    {
        $this->publishes([__DIR__.'/../resources/lang' => resource_path('lang/vendor/bricks-archiver-lite')], 'Bricks-Archiver-Lite-Translations');
        $this->publishes([__DIR__.'/../config/bricks-archiver-lite.php' => config_path('bricks-archiver-lite.php')], 'Bricks-Archiver-Lite-Config');
        $this->publishes([__DIR__.'/../resources/views/' => resource_path('views/vendor/bricks-archiver-lite')], 'Bricks-Archiver-Lite-View');
    }

    /**
     * Registra i componenti per i Template Blade
     */
    public function registerBladeComponent()
    {
        Livewire::component('archiver', Archiver::class);
    }
}

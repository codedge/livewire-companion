<?php

declare(strict_types=1);

namespace Codedge\LivewireCompanion;

use Illuminate\Support\ServiceProvider;

final class LivewireCompanionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/livewire-companion.php' => config_path('livewire-companion.php'),
        ], 'livewire-companion-config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/livewire-companion'),
        ], 'livewire-companion-views');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'livewire-companion');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/livewire-companion.php', 'livewire-companion');
    }
}

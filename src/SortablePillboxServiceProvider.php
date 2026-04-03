<?php

namespace Elcheco\SortablePillbox;

use Elcheco\SortablePillbox\Livewire\SortablePillbox;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class SortablePillboxServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'sortable-pillbox');

        Livewire::addNamespace(
            'sortable-pillbox',
            viewPath: __DIR__.'/../resources/views/livewire',
            classNamespace: 'Elcheco\\SortablePillbox\\Livewire',
            classPath: __DIR__.'/Livewire',
            classViewPath: __DIR__.'/../resources/views/livewire',
        );

        Livewire::component('sortable-pillbox', SortablePillbox::class);

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/sortable-pillbox'),
        ], 'sortable-pillbox-views');
    }
}

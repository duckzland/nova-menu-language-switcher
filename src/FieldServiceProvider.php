<?php

namespace Duckzland\NovaMenuLanguageSwitcher;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\ServiceProvider;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('language-menu-switcher-nova', __DIR__ . '/../dist/js/field.js');
            Nova::style('language-menu-switcher-nova', __DIR__ . '/../dist/css/field.css');
        });
    }
}

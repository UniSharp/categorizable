<?php
namespace UniSharp\Categorizable\Providers;

use Illuminate\Support\ServiceProvider;
use Cviebrock\EloquentTaggable\Services\TagService;
use UniSharp\Categorizable\Services\TagService as UnisharpTagService;

class CategorizableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(
            __DIR__.'/../../database/migrations'
        );

        $this->publishes([
            __DIR__ . '/../../resources/config/categorizable.php' => config_path('categorizable.php'),
        ], 'config');
    }
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../resources/config/categorizable.php', 'categorizable');
    }
}

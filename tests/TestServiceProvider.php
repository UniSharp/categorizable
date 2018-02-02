<?php 
namespace UniSharp\Category\Test;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

/**
 * Class TestServiceProvider
 */
class TestServiceProvider extends LaravelServiceProvider
{

    /**
     * @inheritdoc
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->loadMigrationsFrom(
            __DIR__ . '/database/migrations'
        );
    }
}

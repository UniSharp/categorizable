<?php
namespace UniSharp\Categorizable\Test;

use Kalnoy\Nestedset\NestedSetServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Cviebrock\EloquentTaggable\ServiceProvider;
use UniSharp\Categorizable\Providers\CategorizableServiceProvider;

abstract class TestCase extends Orchestra
{
    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'test']);
        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback');
        });
    }

    protected function getEnvironmentSetUp($app)
    {
        // set up database configuration
        $app['config']->set('database.default', 'test');

        $app['config']->set('database.connections.test', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
            CategorizableServiceProvider::class,
            NestedSetServiceProvider::class,
            TestServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp2($app)
    {
        parent::getEnvironmentSetUp($app);
        $app['config']->set('taggable.taggedModels', "['testModels' => \App\TestModel::class]");
    }

    protected function newModel(array $data = ['title' => 'test'])
    {
        return TestModel::create($data);
    }
}

<?php
namespace UniSharp\Categorizable\Providers;

use Illuminate\Support\ServiceProvider;
use Cviebrock\EloquentTaggable\Services\TagService;
use UniSharp\Categorizable\Services\TagService as UnisharpTagService;

class CategorizableServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(TagService::class, UnisharpTagService::class);
    }
}

<?php
namespace UniSharp\Categorizable;

use Cviebrock\EloquentTaggable\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Categorizable
{
    use Taggable;

    public function categories(): MorphToMany
    {
        return $this->tags();
    }

    public function categorize($categories)
    {
        return $this->tag($categories);
    }

    public function uncategorize($categories)
    {
        return $this->untag($categories);
    }

    public function decategorize($categories)
    {
        return $this->detag($categories);
    }

    public function recategorize($categories)
    {
        return $this->retag($categories);
    }

    public function scopeWithAllCategories(Builder $query, $categories): Builder
    {
        return $this->scopeWithAllTags($query, $tags);
    }
}

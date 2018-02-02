<?php
namespace UniSharp\Category;

use Cviebrock\EloquentTaggable\Taggable;
use Illuminate\Database\Eloquent\Builder;

trait Categorized
{
    use Taggable;
    
    public function tagId($id)
    {
        $tags = (array)$id;
        $this->tag($tags);
    }

    public function retagId($id)
    {
        $tags = (array)$id;
        $this->retag($tags);
    }

    public function untagId($id)
    {
        $tags = (array)$id;
        $this->untag($tags);
    }

    public function detagId($id)
    {
        $tags = (array)$id;
        $this->detag($tags);
    }

    public function scopeWithAllTagsId(Builder $query, $id): Builder
    {
        $tags = (array)$id;
        return $this->scopeWithAllTags($query, $tags);
    }
}

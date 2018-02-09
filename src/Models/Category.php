<?php

namespace UniSharp\Categorizable\Models;

use Cviebrock\EloquentTaggable\Models\Tag;

class Category extends Tag
{
    //
    protected $table = 'taggable_tags';

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}

<?php

namespace UniSharp\Categorizable\Models;

use Cviebrock\EloquentTaggable\Models\Tag;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Tag
{
    use SoftDeletes;
    protected $softCascade = ['categorizable'];
    protected $table = 'taggable_tags';

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function categorizable()
    {
        return $this->morphTo();
    }
}

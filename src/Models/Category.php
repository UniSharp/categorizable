<?php

namespace UniSharp\Categorizable\Models;

use Cviebrock\EloquentTaggable\Models\Tag;

class Category extends Tag
{
    //
    protected $table = 'taggable_tags';
}

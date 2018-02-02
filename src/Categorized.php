<?php
namespace UniSharp\Category;

use Cviebrock\EloquentTaggable\Taggable;
use Cviebrock\EloquentTaggable\Services\TagService;

trait Categorized
{
	use Taggable;
	
    public function tagId($id)
    {
    	$tags = (array)$id;
    	$this->tag($tags);
    }

}

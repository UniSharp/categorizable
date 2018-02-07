<?php
namespace UniSharp\Category\Services;

use Cviebrock\EloquentTaggable\Models\Tag;
use Cviebrock\EloquentTaggable\Services\TagService as OriginalTagService;

class TagService extends OriginalTagService
{
    public function find(string $tagName)
    {
        if (is_numeric($tagName) && $tag = Tag::find($tagName)) {
            return $tag;
        }
        return Tag::byName($tagName)->first();
    }

    public function buildTagArray($tags): array
    {
        if (is_int($tags)) {
            $tags = (string) $tags;
        }

        if (is_iterable($tags)) {
            $tags = collect($tags)->map(function ($tag) {
                return (string) $tag; 
            })->toArray();
        }

        return parent::buildTagArray($tags);
    }
}

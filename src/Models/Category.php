<?php

namespace UniSharp\Categorizable\Models;

use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use NodeTrait;

    protected $fillable = ['name', 'parent_id'];

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($model) {
            collect(array_keys(config('categorizable.morphs')))->each(function ($relation) use ($model) {
                $model->{$relation}()->sync([]);
            });
        });
    }

    public function categorizables($class)
    {
        return $this->morphedByMany($class, 'categorizable');
    }

    public function getRelationValue($key)
    {
        if ($this->relationLoaded($key)) {
            return $this->relations[$key];
        }

        if (array_key_exists($key, config('categorizable.morphs', []))) {
            $class = config('categorizable.morphs')[$key];
            $relation = $this->morphedByMany($class, 'categorizable', 'categorizable', 'id');
            return tap($relation->getResults(), function ($results) use ($key) {
                $this->setRelation($key, $results);
            });
        }

        return parent::getRelationValue($key);
    }


    public function __call($method, $arguments)
    {
        if (array_key_exists($method, config('categorizable.morphs', []))) {
            $class = config('categorizable.morphs')[$method];
            return $this->morphedByMany($class, 'categorizable', 'categorizable', 'id');
        }

        return parent::__call($method, $arguments);
    }
}

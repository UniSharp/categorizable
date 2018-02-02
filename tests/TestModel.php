<?php 
namespace UniSharp\Category\Test;

use UniSharp\Category\Categorized;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TestModel
 */
class TestModel extends Model
{
    use Categorized;

    /**
     * @inheritdoc
     */
    protected $table = 'test_models';

    /**
     * @inheritdoc
     */
    public $timestamps = false;

    /**
     * @inheritdoc
     */
    protected $fillable = ['title'];
}

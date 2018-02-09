<?php
namespace UniSharp\Categorizable\Test;

use UniSharp\Categorizable\Test\TestCase;
use UniSharp\Categorizable\Test\TestModel;
use UniSharp\Categorizable\Models\Category;
use Cviebrock\EloquentTaggable\Services\TagService;
use UniSharp\Categorizable\Services\TagService as UnisharpTagService;

class CategoriesTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->testModel = $this->newModel();
        $this->app->singleton(TagService::class, UnisharpTagService::class);
    }

    // tag所需用id(Integer屬性)
    public function testCategoryAddIntegerId()
    {
        $this->testModel->categorize(1);
        $this->assertCount(1, $this->testModel->tags);
        $arr = [2,3,4,1];
        $this->testModel->categorize($arr);
        $this->assertCount(4, $this->testModel->tags);
    }

    public function testCategorize()
    {
        $model = TestModel::create(['title' => 'test']);
        $model->categorize("News");
        $this->assertEquals("News", $model->categories->pluck('name')->first());
    }

    public function testCategorizeDelimeter()
    {
        $model = TestModel::create(['title' => 'test']);
        $model->categorize("News,Products");
        $this->assertArraySubset(["News", "Products"], $model->categories->pluck('name')->toArray());
    }

    public function testCategorizeArray()
    {
        $model = TestModel::create(['title' => 'test']);
        $model->categorize(["News", "Products"]);
        $this->assertArraySubset(["News", "Products"], $model->categories->pluck('name')->toArray());
    }

    public function testCategorizeById()
    {
        $model = TestModel::create(['title' => 'test']);
        $foo = Category::create(["name" => "foo"]);
        $bar = Category::create(["name" => "bar"]);
        $model->categorize("{$bar->tag_id}");
        $this->assertCount(1, $model->categories);
        $this->assertEquals($bar->id, $model->categories->pluck('id')->first());
    }

    public function testCategorizeByManyId()
    {
        $model = TestModel::create(['title' => 'test']);
        $foo = Category::create(["name" => "foo"]);
        $bar = Category::create(["name" => "bar"]);
        $model->categorize(["{$foo->tag_id}", "{$bar->tag_id}"]);
        $this->assertCount(2, $model->categories);
        $this->assertEquals([$foo->tag_id, $bar->tag_id], $model->categories->pluck('tag_id')->toArray());
    }
    
    public function testCategoryUnTagId()
    {
        $this->testModel->categorize([1,2,3]);
        $this->testModel->uncategorize(1);
        $this->assertEquals(
            "2,3",
            $this->testModel->tagList
        );
    }

    public function testCategoryReTagId()
    {
        $this->testModel->categorize(1);
        $this->testModel->recategorize(2);
        $this->assertEquals(
            2,
            $this->testModel->tagList
        );
    }

    public function testCategoryDeTagId()
    {
        $this->testModel->categorize(1);
        $this->testModel->uncategorize(1);
        $this->assertEquals(
            "",
            $this->testModel->tagList
        );
    }

    public function testAssociateParent()
    {
        $parent = Category::create(['name' => 'parent']);
        $child = Category::create(['name' => 'child']);

        $child->parent()->associate($parent)->save();

        $this->assertEquals('child', $parent->refresh()->children->first()->name);
    }
}

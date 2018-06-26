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
        $this->app->singleton(TagService::class, UnisharpTagService::class);
    }

    public function testNormalizeInteger()
    {
        $foo = Category::create(['name' => 'foo']);
        $bar = Category::create(['name' => 'bar']);
        $model = new TestModel;
        $this->assertArraySubset([$foo->id, $bar->id], $model->normalize([$foo->id, $bar->id]));
    }

    public function testNormalizeString()
    {
        $foo = Category::create(['name' => 'foo']);
        $model = new TestModel;
        $this->assertArraySubset([$foo->id], $model->normalize(['foo', 'bar']));
        $this->assertDatabaseHas('categories', ['name' => 'bar']);
    }

    public function testNormalizeNestedArray()
    {
        $foo = Category::create(['name' => 'foo']);
        $bar = Category::create(['name' => 'bar']);
        $model = new TestModel;
        $this->assertArraySubset([$foo->id, $bar->id], $model->normalize([[$foo->id, $bar->id]]));
    }

    public function testNormalizeNonExistence()
    {
        $foo = Category::create(['name' => 'foo']);
        $model = new TestModel;
        $this->assertEquals([$foo->id], $model->normalize([$foo->id, 15]));
    }

    public function testCategorizeIntegerIds()
    {
        $foo = Category::create(['name' => 'foo']);
        $thing = TestModel::create(['title' => 'foo']);
        $thing->categorize($foo->id);

        $this->assertDatabaseHas('categorizable', [
            'categorizable_type' => TestModel::class,
            'categorizable_id' => $thing->id,
            'category_id' => $foo->id
        ]);

        $biz = Category::create(['name' => 'biz']);
        $baz = Category::create(['name' => 'baz']);
        $thing->categorize([$biz->id, $baz->id]);
        $this->assertDatabaseHas('categorizable', [
            'categorizable_type' => TestModel::class,
            'categorizable_id' => $thing->id,
            'category_id' => $biz->id,
        ]);

        $this->assertDatabaseHas('categorizable', [
            'categorizable_type' => TestModel::class,
            'categorizable_id' => $thing->id,
            'category_id' => $baz->id
        ]);
    }

    public function testCategorizeDuplicatedIntegerIds()
    {
        $foo = Category::create(['name' => 'foo']);
        $thing = TestModel::create(['title' => 'foo']);

        $thing->categorize($foo->id);
        $thing->categorize($foo->id);
        $this->assertCount(1, $thing->categories);
    }

    public function testCategorizeString()
    {
        $model = TestModel::create(['title' => 'test']);
        $model->categorize("News");
        $this->assertEquals("News", $model->categories->pluck('name')->first());
    }

    public function testCategorizeArray()
    {
        $model = TestModel::create(['title' => 'test']);
        $model->categorize(["News", "Products"]);
        $this->assertArraySubset(["News", "Products"], $model->categories->pluck('name')->toArray());
    }

    public function testUncategorizeIds()
    {
        $foo = Category::create(['name' => 'foo']);
        $bar = Category::create(['name' => 'bar']);
        $thing = TestModel::create(['title' => 'foo']);

        $thing->categories()->attach([$foo->id, $bar->id]);
        $thing->uncategorize($bar->id);
        $this->assertCount(1, $thing->categories);
        $this->assertDatabaseHas('categorizable', [
            'categorizable_type' => TestModel::class,
            'categorizable_id' => $thing->id,
            'category_id' => $foo->id,
        ]);

        $this->assertDatabaseMissing('categorizable', [
            'categorizable_type' => TestModel::class,
            'categorizable_id' => $thing->id,
            'category_id' => $bar->id
        ]);
    }

    public function testRecategorizeIds()
    {
        $foo = Category::create(['name' => 'foo']);
        $bar = Category::create(['name' => 'bar']);
        $thing = TestModel::create(['title' => 'foo']);

        $thing->categories()->attach([$foo->id]);
        $thing->recategorize($bar->id);
        $this->assertCount(1, $thing->categories);
        $this->assertDatabaseHas('categorizable', [
            'categorizable_type' => TestModel::class,
            'categorizable_id' => $thing->id,
            'category_id' => $bar->id,
        ]);

        $this->assertDatabaseMissing('categorizable', [
            'categorizable_type' => TestModel::class,
            'categorizable_id' => $thing->id,
            'category_id' => $foo->id
        ]);
    }

    public function testCategoryDeaategorize()
    {
        $foo = Category::create(['name' => 'foo']);
        $thing = TestModel::create(['title' => 'foo']);
        $thing->categories()->attach([$foo->id]);
        $thing->decategorize();

        $this->assertDatabaseMissing('categorizable', [
            'categorizable_type' => TestModel::class,
            'categorizable_id' => $thing->id,
            'category_id' => $foo->id,
        ]);
    }

    public function testAssociateParent()
    {
        $parent = Category::create(['name' => 'parent']);
        $child = Category::create(['name' => 'child', 'parent_id' => $parent->id]);

        $this->assertEquals('child', $parent->refresh()->children->first()->name);
    }

    public function testRemoveCategory()
    {
        $category = Category::create(['name' => 'parent']);
        $thing = TestModel::create(['title' => 'foo']);
        config()->set('categorizable.morphs', ['tests' => TestModel::class]);
        $thing->categorize($category->id);
        $result = $category->delete();

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
        $this->assertDatabaseMissing('categorizable', [
            'categorizable_id' => $thing->id,
            'categorizable_type' => TestModel::class
        ]);
    }
}

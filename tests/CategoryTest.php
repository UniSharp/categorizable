<?php
namespace UniSharp\Category\Test;

use UniSharp\Category\Test\TestCase;
use UniSharp\Category\Models\Category;
use UniSharp\Category\Test\TestModel;

class CategoriesTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->testModel = $this->newModel();
    }

    // tag所需用id(Integer屬性)
    public function testCategoryAddIntegerId()
    {
        $this->testModel->tagId(1);
        $this->assertCount(1, $this->testModel->tags);
        $arr = [2,3,4,1];
        $this->testModel->tagId($arr);
        $this->assertCount(4, $this->testModel->tags);
    }
    
    // 
    public function testCategoryUnTagId()
    {
        $this->testModel->tagId([1,2,3]);
        $this->testModel->untagId(1);
        $this->assertEquals("2,3", 
            $this->testModel->tagList);
    }

    public function testCategoryReTagId()
    {
        $this->testModel->tagId(1);
        $this->testModel->retagId(2);
        $this->assertEquals(2, 
            $this->testModel->tagList);
    }

    public function testCategoryDeTagId()
    {
        $this->testModel->tagId(1);
        $this->testModel->detagId(1);
        $this->assertEquals("", 
            $this->testModel->tagList);
    }

    public function testIntegerOneIdGetModel()
    {
        $arr = [2,3,4,1];
        $this->testModel->tagId($arr);
        $model = $this->newModel(["title" => "apple"]);
        $model->tagId(2);
        $test = $this->newModel(["title" => "banana"]);
        $this->assertCount(2, TestModel::withAllTagsId(2)->get());
        $title = TestModel::withAllTagsId([2])->get();
        $this->assertEquals("apple", 
            $title[1]->title);
    }

    public function testIntegerManyIdGetModel()
    {
        $arr = [2,3,4,1];
        $this->testModel->tagId($arr);
        $model = $this->newModel(["title" => "apple"]);
        $model->tagId(2);
        $test = $this->newModel(["title" => "banana"]);
        $this->assertCount(2, TestModel::withAllTagsId(2)->get());
        $title = TestModel::withAllTagsId([2,4])->get();
        $this->assertEquals("test", 
            $title[0]->title);
    }
}

<?php
namespace UniSharp\Category\Test;

use UniSharp\Category\Test\TestCase;
use UniSharp\Category\Models\Category;

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
    }
    
    // 

    public function testCategoryGetId(){
        $this->testModel->tagId(1);
        $this->testModel->tagId(2);

        $this->assertCount(2, $this->testModel->tags);
    }

    public function testIntegerIdGetModel(){
        $model = $this->newModel(['title' => 'ccc']);
        $model->tagId(1);
        $model->tagId(3);
        $this->testModel->tagId(1);
        $this->testModel->tagId(2);
        $this->assertCount(2, $this->testModel->tags);
        $this->assertCount(2, $model->tags);
    }
}

<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class ElasticquentTraitTest extends PHPUnit_Framework_TestCase {

    public $modelData = array('name' => 'Test Name');

    /**
     * Testing Model
     *
     * @return void
     */
    public function testingModel()
    {
        $model = new TestModel;
        $model->fill($this->modelData);

        return $model;
    }

    /**
     *
     *
     * @return void
     */
    public function testGetTypeName()
    {
        $model = $this->testingModel();
        $this->assertEquals('testing', $model->getTypeName());
    }

    /**
     * Test Uses Timestamp In Index
     */
    public function testBasicPropertiesGetters()
    {
        $model = $this->testingModel();

        $model->useTimestampsInIndex();
        $this->assertTrue($model->usesTimestampsInIndex());

        $model->dontUseTimestampsInIndex();
        $this->assertFalse($model->usesTimestampsInIndex());
    }

    /**
     * Testing Mapping Setup
     */
    public function testMappingSetup()
    {
        $model = $this->testingModel();

        $mapping = array('foo' => 'bar');

        $model->setMappingProperties($mapping);
        $this->assertEquals($mapping, $model->getMappingProperties());
    }

    /**
     * Test Index Document Data
     *
     * @return void
     */
    public function testIndexDocumentData()
    {
        // Basic
        $model = $this->testingModel();
        $this->assertEquals($this->modelData, $model->getIndexDocumentData());

        // Custom
        $custom = new CustomTestModel();
        $custom->fill($this->modelData);

        $this->assertEquals(
                array('foo' => 'bar'), $custom->getIndexDocumentData());
    }

}

class TestModel extends Eloquent implements \Adamfairholm\Elasticquent\ElasticquentInterface {

    use Adamfairholm\Elasticquent\ElasticquentTrait;

    protected $fillable = array('name');

    function getTable()
    {
        return 'testing';
    }
}

class CustomTestModel extends Eloquent implements \Adamfairholm\Elasticquent\ElasticquentInterface {

    use Adamfairholm\Elasticquent\ElasticquentTrait;

    protected $fillable = array('name');

    function getIndexDocumentData()
    {
        return array('foo' => 'bar');
    }
}

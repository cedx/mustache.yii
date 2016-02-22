<?php
/**
 * @file
 * Implementation of the `yii\test\mustache\CacheTest` class.
 */
namespace yii\test\mustache;

// Dependencies.
use yii\mustache\Cache;
use yii\mustache\ViewRenderer;

/**
 * Tests the features of the `yii\mustache\Cache` class.
 */
class CacheTest extends \PHPUnit_Framework_TestCase {

  /**
   * @var yii::mustache::Cache $model
   * The data context of the tests.
   */
  private $model;

  /**
   * Tests the `cache` method.
   */
  public function testCache() {
    $this->model->cache('key', '<?php class YiiMustacheTemplateTestModel {}');
    $this->assertTrue(class_exists('YiiMustacheTemplateTestModel'));
  }

  /**
   * Tests the `load` method.
   */
  public function testLoad() {
    $this->assertFalse($this->model->load('key'));
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp() {
    $this->model = new Cache(new ViewRenderer());
  }
}

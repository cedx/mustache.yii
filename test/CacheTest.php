<?php
/**
 * Implementation of the `yii\test\mustache\CacheTest` class.
 */
namespace yii\test\mustache;
use yii\mustache\{Cache, ViewRenderer};

/**
 * Tests the features of the `yii\mustache\Cache` class.
 */
class CacheTest extends \PHPUnit_Framework_TestCase {

  /**
   * @var Cache The data context of the tests.
   */
  private $model;

  /**
   * Tests the `Cache::cache()` method.
   */
  public function testCache() {
    $this->model->cache('key', '<?php class YiiMustacheTemplateTestModel {}');
    $this->assertTrue(class_exists('YiiMustacheTemplateTestModel'));
  }

  /**
   * Tests the `Cache::load()` method.
   */
  public function testLoad() {
    $this->assertFalse($this->model->load('key'));
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp() {
    $this->model = new Cache(['viewRenderer' => \Yii::createObject(ViewRenderer::class)]);
  }
}

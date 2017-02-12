<?php
/**
 * Implementation of the `yii\test\mustache\CacheTest` class.
 */
namespace yii\test\mustache;

use PHPUnit\Framework\{TestCase};
use yii\mustache\{Cache, ViewRenderer};

/**
 * @coversDefaultClass \yii\mustache\Cache
 */
class CacheTest extends TestCase {

  /**
   * @var Cache The data context of the tests.
   */
  private $model;

  /**
   * @test ::cache
   */
  public function testCache() {
    $this->model->cache('key', '<?php class YiiMustacheTemplateTestModel {}');
    $this->assertTrue(class_exists('YiiMustacheTemplateTestModel'));
  }

  /**
   * @test ::load
   */
  public function testLoad() {
    $this->assertFalse($this->model->load('key'));
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp() {
    $this->model = new Cache(\Yii::createObject(ViewRenderer::class));
  }
}

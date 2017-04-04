<?php
namespace yii\mustache;
use PHPUnit\Framework\{TestCase};

/**
 * Tests the features of the `yii\mustache\Cache` class.
 */
class CacheTest extends TestCase {

  /**
   * @var Cache The data context of the tests.
   */
  private $model;

  /**
   * @test Cache::cache
   */
  public function testCache() {
    $this->model->cache('key', '<?php class YiiMustacheTemplateTestModel {}');
    $this->assertTrue(class_exists('YiiMustacheTemplateTestModel'));
  }

  /**
   * @test Cache::load
   */
  public function testLoad() {
    $this->assertFalse($this->model->load('key'));
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp() {
    $this->model = new Cache(['viewRenderer' => new ViewRenderer()]);
  }
}

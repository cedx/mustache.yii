<?php
declare(strict_types=1);
namespace yii\mustache;

use function PHPUnit\Expect\{expect, it};
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
  public function testCache(): void {
    it('should evaluate the PHP code put in cache', function() {
      $this->model->cache('key', '<?php class YiiMustacheTemplateTestModel {}');
      expect(class_exists('YiiMustacheTemplateTestModel'))->to->be->true;
    });
  }

  /**
   * @test Cache::load
   */
  public function testLoad(): void {
    it('should return `false` for an unknown key', function() {
      expect($this->model->load('key'))->to->be->false;
    });
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp(): void {
    $this->model = new Cache([
      'viewRenderer' => \Yii::createObject(ViewRenderer::class)
    ]);
  }
}

<?php declare(strict_types=1);
namespace yii\mustache;

use function PHPUnit\Expect\{expect, it};
use PHPUnit\Framework\{TestCase};

/** @testdox yii\mustache\Cache */
class CacheTest extends TestCase {

  /** @var Cache The data context of the tests. */
  private $model;

  /** @testdox ->cache() */
  function testCache(): void {
    it('should evaluate the PHP code put in cache', function() {
      $this->model->cache('key', '<?php class YiiMustacheTemplateTestModel {}');
      expect(class_exists('YiiMustacheTemplateTestModel'))->to->be->true;
    });
  }

  /** @testdox ->load() */
  function testLoad(): void {
    it('should return `false` for an unknown key', function() {
      expect($this->model->load('key'))->to->be->false;
    });
  }

  /** @before This method is called before each test. */
  protected function setUp(): void {
    $this->model = new Cache(['viewRenderer' => new ViewRenderer]);
  }
}

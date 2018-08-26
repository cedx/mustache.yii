<?php
declare(strict_types=1);
namespace yii\mustache;

use PHPUnit\Framework\{TestCase};
use yii\console\{Application};

/**
 * Tests the features of the `yii\mustache\Cache` class.
 */
class CacheTest extends TestCase {

  /**
   * @var Cache The data context of the tests.
   */
  private $model;

  /**
   * Tests the `Cache::cache
   */
  function testCache(): void {
    // It should evaluate the PHP code put in cache.
      $this->model->cache('key', '<?php class YiiMustacheTemplateTestModel {}');
      assertThat(class_exists('YiiMustacheTemplateTestModel'), isTrue());
    });
  }

  /**
   * Tests the `Cache::load
   */
  function testLoad(): void {
    // It should return `false` for an unknown key.
      assertThat($this->model->load('key'), isFalse());
    });
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp(): void {
    new Application(['id' => 'yii2-free-mobile', 'basePath' => '@root/lib']);
    $this->model = new Cache(['viewRenderer' => new ViewRenderer]);
  }
}

<?php declare(strict_types=1);
namespace yii\mustache;

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\{assertThat, isFalse, isTrue};

/** @testdox yii\mustache\Cache */
class CacheTest extends TestCase {

	/** @var Cache The data context of the tests. */
	private Cache $model;

	/** @testdox ->cache() */
	function testCache(): void {
		// It should evaluate the PHP code put in cache.
		$this->model->cache("key", "<?php class YiiMustacheTemplateTestModel {}");
		assertThat(class_exists("YiiMustacheTemplateTestModel"), isTrue());
	}

	/** @testdox ->load() */
	function testLoad(): void {
		// It should return `false` for an unknown key.
		assertThat($this->model->load("key"), isFalse());
	}

	/** @before This method is called before each test. */
	protected function setUp(): void {
		$this->model = new Cache(["viewRenderer" => new ViewRenderer]);
	}
}

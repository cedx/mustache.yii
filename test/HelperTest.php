<?php declare(strict_types=1);
namespace yii\mustache;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use function PHPUnit\Framework\{assertThat, equalTo};

/** @testdox yii\mustache\Helper */
class HelperTest extends TestCase {

	/** @var \ReflectionClass<Helper> The object used to change the visibility of inaccessible class members. */
	private static \ReflectionClass $reflection;

	/** @var MockObject The data context of the tests. */
	private MockObject $model;

	/** @beforeClass This method is called before the first test of this test class is run. */
	static function setUpBeforeClass(): void {
		self::$reflection = new \ReflectionClass(Helper::class);
	}

	/** @testdox ->captureOutput() */
	function testCaptureOutput(): void {
		$method = self::$reflection->getMethod("captureOutput");
		$method->setAccessible(true);

		// It should return the content of the output buffer.
		assertThat($method->invoke($this->model, fn() => print "Hello World!"), equalTo("Hello World!"));
	}

	/** @testdox ->parseArguments() */
	function testParseArguments(): void {
		$method = self::$reflection->getMethod("parseArguments");
		$method->setAccessible(true);

		// It should transform a single value into an array.
		$expected = ["foo" => "FooBar"];
		assertThat($method->invoke($this->model, "FooBar", "foo"), equalTo($expected));

		$expected = ["foo" => "FooBar", "bar" => ["baz" => false]];
		assertThat($method->invoke($this->model, "FooBar", "foo", ["bar" => ["baz" => false]]), equalTo($expected));

		// It should transform a JSON string into an array.
		$data = '{
			"foo": "FooBar",
			"bar": {"baz": true}
		}';

		$expected = ["foo" => "FooBar", "bar" => ["baz" => true], "BarFoo" => [123, 456]];
		assertThat($method->invoke($this->model, $data, "foo", ["BarFoo" => [123, 456]]), equalTo($expected));

		$data = '{"foo": [123, 456]}';
		$expected = ["foo" => [123, 456], "bar" => ["baz" => false]];
		assertThat($method->invoke($this->model, $data, "foo", ["bar" => ["baz" => false]]), equalTo($expected));
	}

	/** @before This method is called before each test. */
	protected function setUp(): void {
		$this->model = $this->getMockForAbstractClass(Helper::class);
	}
}

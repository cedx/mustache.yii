<?php declare(strict_types=1);
namespace yii\mustache;

use function PHPUnit\Expect\{expect, it};
use PHPUnit\Framework\{TestCase};
use PHPUnit\Framework\MockObject\{MockObject};

/** @testdox yii\mustache\Helper */
class HelperTest extends TestCase {

  /** @var \ReflectionClass The object used to change the visibility of inaccessible class members. */
  private static \ReflectionClass $reflection;

  /** @var MockObject The data context of the tests. */
  private MockObject $model;

  /** @beforeClass This method is called before the first test of this test class is run. */
  static function setUpBeforeClass(): void {
    self::$reflection = new \ReflectionClass(Helper::class);
  }

  /** @testdox ->captureOutput() */
  function testCaptureOutput(): void {
    $method = self::$reflection->getMethod('captureOutput');
    $method->setAccessible(true);

    it('should return the content of the output buffer', function() use ($method) {
      expect($method->invoke($this->model, function() { echo 'Hello World!'; }))->to->equal('Hello World!');
    });
  }

  /** @testdox ->parseArguments() */
  function testParseArguments(): void {
    $method = self::$reflection->getMethod('parseArguments');
    $method->setAccessible(true);

    it('should transform a single value into an array', function() use ($method) {
      $expected = ['foo' => 'FooBar'];
      expect($method->invoke($this->model, 'FooBar', 'foo'))->to->equal($expected);

      $expected = ['foo' => 'FooBar', 'bar' => ['baz' => false]];
      expect($method->invoke($this->model, 'FooBar', 'foo', ['bar' => ['baz' => false]]))->to->equal($expected);
    });

    it('should transform a JSON string into an array', function() use ($method) {
      $data = '{
        "foo": "FooBar",
        "bar": {"baz": true}
      }';

      $expected = ['foo' => 'FooBar', 'bar' => ['baz' => true], 'BarFoo' => [123, 456]];
      expect($method->invoke($this->model, $data, 'foo', ['BarFoo' => [123, 456]]))->to->equal($expected);

      $data = '{"foo": [123, 456]}';
      $expected = ['foo' => [123, 456], 'bar' => ['baz' => false]];
      expect($method->invoke($this->model, $data, 'foo', ['bar' => ['baz' => false]]))->to->equal($expected);
    });
  }

  /** @before This method is called before each test. */
  protected function setUp(): void {
    $this->model = $this->getMockForAbstractClass(Helper::class);
  }
}

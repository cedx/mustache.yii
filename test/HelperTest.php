<?php
declare(strict_types=1);
namespace yii\mustache;

use PHPUnit\Framework\{TestCase};

/**
 * Tests the features of the `yii\mustache\helpers\Helper` class.
 */
class HelperTest extends TestCase {

  /**
   * @var \ReflectionClass The object used to change the visibility of inaccessible class members.
   */
  private static $reflection;

  /**
   * @var \PHPUnit\Framework\MockObject\MockObject The data context of the tests.
   */
  private $model;

  /**
   * This method is called before the first test of this test class is run.
   * @beforeClass
   */
  static function setUpBeforeClass(): void {
    static::$reflection = new \ReflectionClass(Helper::class);
  }

  /**
   * Tests the `Helper::captureOutput()` method.
   * @test
   */
  function testCaptureOutput(): void {
    $method = static::$reflection->getMethod('captureOutput');
    $method->setAccessible(true);

    // It should return the content of the output buffer.
    assertThat($method->invoke($this->model, function() { echo 'Hello World!'; }), equalTo('Hello World!'));
  }

  /**
   * Tests the `Helper::parseArguments()` method.
   * @test
   */
  function testParseArguments(): void {
    $method = static::$reflection->getMethod('parseArguments');
    $method->setAccessible(true);

    // It should transform a single value into an array.
    $expected = ['foo' => 'FooBar'];
    assertThat($method->invoke($this->model, 'FooBar', 'foo'), equalTo($expected));

    $expected = ['foo' => 'FooBar', 'bar' => ['baz' => false]];
    assertThat($method->invoke($this->model, 'FooBar', 'foo', ['bar' => ['baz' => false]]), equalTo($expected));

    // It should transform a JSON string into an array.
    $data = '{
      "foo": "FooBar",
      "bar": {"baz": true}
    }';

    $expected = ['foo' => 'FooBar', 'bar' => ['baz' => true], 'BarFoo' => [123, 456]];
    assertThat($method->invoke($this->model, $data, 'foo', ['BarFoo' => [123, 456]]), equalTo($expected));

    $data = '{"foo": [123, 456]}';
    $expected = ['foo' => [123, 456], 'bar' => ['baz' => false]];
    assertThat($method->invoke($this->model, $data, 'foo', ['bar' => ['baz' => false]]), equalTo($expected));
  }

  /**
   * This method is called before each test.
   * @before
   */
  protected function setUp(): void {
    $this->model = $this->getMockForAbstractClass(Helper::class);
  }
}

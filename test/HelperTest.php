<?php
declare(strict_types=1);
namespace yii\mustache;

use PHPUnit\Framework\{TestCase};

/**
 * Tests the features of the `yii\mustache\helpers\Helper` class.
 */
class HelperTest extends TestCase {

  /**
   * @var Helper The data context of the tests.
   */
  private $model;

  /**
   * Tests the `Helper::captureOutput()` method.
   * @test
   */
  function testCaptureOutput(): void {
    $captureOutput = function($callback) {
      return $this->captureOutput($callback);
    };

    // It should return the content of the output buffer.
    assertThat($captureOutput->call($this->model, function() { echo 'Hello World!'; }), equalTo('Hello World!');
  }

  /**
   * Tests the `Helper::parseArguments()` method.
   * @test
   */
  function testParseArguments(): void {
    $parseArguments = function($text, $defaultArgument, $defaultValues = []) {
      return $this->parseArguments($text, $defaultArgument, $defaultValues);
    };

    // It should transform a single value into an array.
    $expected = ['foo' => 'FooBar'];
    assertThat($parseArguments->call($this->model, 'FooBar', 'foo'), equalTo($expected);

    $expected = ['foo' => 'FooBar', 'bar' => ['baz' => false]];
    assertThat($parseArguments->call($this->model, 'FooBar', 'foo', ['bar' => ['baz' => false]]), equalTo($expected);

    // It should transform a JSON string into an array.
    $data = '{
      "foo": "FooBar",
      "bar": {"baz": true}
    }';

    $expected = ['foo' => 'FooBar', 'bar' => ['baz' => true], 'BarFoo' => [123, 456]];
    assertThat($parseArguments->call($this->model, $data, 'foo', ['BarFoo' => [123, 456]]), equalTo($expected);

    $data = '{"foo": [123, 456]}';
    $expected = ['foo' => [123, 456], 'bar' => ['baz' => false]];
    assertThat($parseArguments->call($this->model, $data, 'foo', ['bar' => ['baz' => false]]), equalTo($expected);
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   * @before
   */
  protected function setUp(): void {
    $this->model = $this->getMockForAbstractClass(Helper::class));
  }
}

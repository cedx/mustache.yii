<?php
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
   * @test Helper::captureOutput
   */
  public function testCaptureOutput() {
    $captureOutput = function(callable $callback) {
      return $this->captureOutput($callback);
    };

    $this->assertEquals('Hello World!', $captureOutput->call($this->model, function() {
      echo 'Hello World!';
    }));
  }

  /**
   * @test Helper::parseArguments
   */
  public function testParseArguments() {
    $parseArguments = function(string $text, string $defaultArgument, array $defaultValues = []) {
      return $this->parseArguments($text, $defaultArgument, $defaultValues);
    };

    $expected = ['foo' => 'FooBar'];
    $this->assertEquals($expected, $parseArguments->call($this->model, 'FooBar', 'foo'));

    $expected = ['foo' => 'FooBar', 'bar' => ['baz' => false]];
    $this->assertEquals($expected, $parseArguments->call($this->model, 'FooBar', 'foo', ['bar' => ['baz' => false]]));

    $data = '{
      "foo": "FooBar",
      "bar": {"baz": true}
    }';

    $expected = ['foo' => 'FooBar', 'bar' => ['baz' => true], 'BarFoo' => [123, 456]];
    $this->assertEquals($expected, $parseArguments->call($this->model, $data, 'foo', ['BarFoo' => [123, 456]]));

    $data = '{
      "foo": [123, 456]
    }';

    $expected = ['foo' => [123, 456], 'bar' => ['baz' => false]];
    $this->assertEquals($expected, $parseArguments->call($this->model, $data, 'foo', ['bar' => ['baz' => false]]));
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp() {
    $this->model = $this->getMockForAbstractClass(Helper::class);
  }
}

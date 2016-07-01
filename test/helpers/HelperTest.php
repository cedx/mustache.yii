<?php
/**
 * Implementation of the `yii\test\mustache\helpers\HelperTest` class.
 */
namespace yii\test\mustache\helpers;

// Module dependencies.
use yii\mustache\helpers\Helper;

/**
 * Publicly exposes the features of the `yii\mustache\helpers\Helper` class.
 */
class HelperStub extends Helper {

  /**
   * Returns the output sent by the call of the specified function.
   * @param callable $callback The function to invoke.
   * @return The captured output.
   */
  public function captureOutput(callable $callback): string {
    return parent::captureOutput($callback);
  }

  /**
   * Parses the arguments of a parametrized helper.
   * Arguments can be specified as a single value, or as a string in JSON format.
   * @param $text The section content specifying the helper arguments.
   * @param $defaultArgument The name of the default argument. This is used when the section content provides a plain string instead of a JSON object.
   * @param $defaultValues The default values of arguments. These are used when the section content does not specify all arguments.
   * @return The parsed arguments as an associative array.
   */
  public function parseArguments(string $text, string $defaultArgument, array $defaultValues = []): array {
    return parent::parseArguments($text, $defaultArgument, $defaultValues);
  }
}

/**
 * Tests the features of the `yii\mustache\helpers\Helper` class.
 */
class HelperTest extends \PHPUnit_Framework_TestCase {

  /**
   * Tests the `captureOutput` method.
   */
  public function testCaptureOutput() {
    $model = new HelperStub();
    $this->assertEquals('Hello World!', $model->captureOutput(function() {
      echo 'Hello World!';
    }));
  }

  /**
   * Tests the `parseArguments` method.
   */
  public function testParseArguments() {
    $model = new HelperStub();

    $expected = ['foo' => 'FooBar'];
    $this->assertEquals($expected, $model->parseArguments('FooBar', 'foo'));

    $expected = ['foo' => 'FooBar', 'bar' => ['baz' => false]];
    $this->assertEquals($expected, $model->parseArguments('FooBar', 'foo', ['bar' => ['baz' => false]]));

    $data = '{
      "foo": "FooBar",
      "bar": {"baz": true}
    }';

    $expected = ['foo' => 'FooBar', 'bar' => ['baz' => true], 'BarFoo' => [123, 456]];
    $this->assertEquals($expected, $model->parseArguments($data, 'foo', ['BarFoo' => [123, 456]]));

    $data = '{
      "foo": [123, 456]
    }';

    $expected = ['foo' => [123, 456], 'bar' => ['baz' => false]];
    $this->assertEquals($expected, $model->parseArguments($data, 'foo', ['bar' => ['baz' => false]]));
  }
}

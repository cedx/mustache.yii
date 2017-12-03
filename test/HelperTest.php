<?php
declare(strict_types=1);
namespace yii\mustache;

use function PHPUnit\Expect\{expect, it};
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
  public function testCaptureOutput(): void {
    $captureOutput = function($callback) {
      return $this->captureOutput($callback);
    };

    it('should return the content of the output buffer', function() use ($captureOutput) {
      expect($captureOutput->call($this->model, function() { echo 'Hello World!'; }))->to->equal('Hello World!');
    });
  }

  /**
   * @test Helper::parseArguments
   */
  public function testParseArguments(): void {
    $parseArguments = function($text, $defaultArgument, $defaultValues = []) {
      return $this->parseArguments($text, $defaultArgument, $defaultValues);
    };

    it('should transform a single value into an array', function() use ($parseArguments) {
      $expected = ['foo' => 'FooBar'];
      expect($parseArguments->call($this->model, 'FooBar', 'foo'))->to->equal($expected);

      $expected = ['foo' => 'FooBar', 'bar' => ['baz' => false]];
      expect($parseArguments->call($this->model, 'FooBar', 'foo', ['bar' => ['baz' => false]]))->to->equal($expected);
    });

    it('should transform a JSON string into an array', function() use ($parseArguments) {
      $data = '{
        "foo": "FooBar",
        "bar": {"baz": true}
      }';

      $expected = ['foo' => 'FooBar', 'bar' => ['baz' => true], 'BarFoo' => [123, 456]];
      expect($parseArguments->call($this->model, $data, 'foo', ['BarFoo' => [123, 456]]))->to->equal($expected);

      $data = '{"foo": [123, 456]}';
      $expected = ['foo' => [123, 456], 'bar' => ['baz' => false]];
      expect($parseArguments->call($this->model, $data, 'foo', ['bar' => ['baz' => false]]))->to->equal($expected);
    });
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp(): void {
    $this->model = $this->getMockForAbstractClass(Helper::class);
  }
}

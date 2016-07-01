<?php
/**
 * Implementation of the `yii\test\mustache\LoggerTest` class.
 */
namespace yii\test\mustache;

// Module dependencies.
use yii\base\InvalidParamException;
use yii\mustache\Logger;

/**
 * Tests the features of the `yii\mustache\Logger` class.
 */
class LoggerTest extends \PHPUnit_Framework_TestCase {

  /**
   * @var yii\mustache\Logger $model
   * The data context of the tests.
   */
  private $model;

  /**
   * Tests the `log` method.
   */
  public function testLog() {
    $this->expectException(InvalidParamException::class);
    $this->model->log('dummy', 'Hello World!');
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp() {
    $this->model = new Logger();
  }
}

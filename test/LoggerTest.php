<?php
/**
 * Implementation of the `yii\test\mustache\LoggerTest` class.
 */
namespace yii\test\mustache;

use PHPUnit\Framework\{TestCase};
use yii\base\{InvalidParamException};
use yii\mustache\{Logger};

/**
 * @coversDefaultClass \yii\mustache\Logger
 */
class LoggerTest extends TestCase {

  /**
   * @var Logger The data context of the tests.
   */
  private $model;

  /**
   * @test ::log
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

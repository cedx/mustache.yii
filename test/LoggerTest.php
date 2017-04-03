<?php
namespace yii\mustache;

use PHPUnit\Framework\{TestCase};
use yii\base\{InvalidParamException};

/**
 * Tests the features of the `yii\mustache\Logger` class.
 */
class LoggerTest extends TestCase {

  /**
   * @var Logger The data context of the tests.
   */
  private $model;

  /**
   * @test Logger::log
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

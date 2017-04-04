<?php
namespace yii\mustache;

use PHPUnit\Framework\{TestCase};
use yii\base\{InvalidParamException};

/**
 * Tests the features of the `yii\mustache\Logger` class.
 */
class LoggerTest extends TestCase {

  /**
   * @test Logger::log
   */
  public function testLog() {
    it('', function() {

    });

    $this->expectException(InvalidParamException::class);
    (new Logger())->log('dummy', 'Hello World!');
  }
}

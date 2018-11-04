<?php
declare(strict_types=1);
namespace yii\mustache;

use PHPUnit\Framework\{TestCase};
use yii\base\{InvalidArgumentException};

/**
 * Tests the features of the `yii\mustache\Logger` class.
 */
class LoggerTest extends TestCase {

  /**
   * Tests the `Logger::log()` method.
   * @test
   */
  function testLog(): void {
    // It should throw an exception if the log level is invalid.
    $this->expectException(InvalidArgumentException::class);
    (new Logger)->log(666, 'Hello World!');
  }
}

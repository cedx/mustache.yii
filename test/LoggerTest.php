<?php
declare(strict_types=1);
namespace yii\mustache;

use PHPUnit\Framework\{TestCase};
use yii\base\{InvalidParamException};

/**
 * Tests the features of the `yii\mustache\Logger` class.
 */
class LoggerTest extends TestCase {

  /**
   * Tests the `Logger::log
   */
  function testLog(): void {
    // It should throw an exception if the log level is invalid.
      assertThat(function() { (new Logger)->log('dummy', 'Hello World!'); })->to->throw(InvalidParamException::class));
    });
  }
}

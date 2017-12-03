<?php
declare(strict_types=1);
namespace yii\mustache;

use function PHPUnit\Expect\{expect, it};
use PHPUnit\Framework\{TestCase};
use yii\base\{InvalidParamException};

/**
 * Tests the features of the `yii\mustache\Logger` class.
 */
class LoggerTest extends TestCase {

  /**
   * @test Logger::log
   */
  public function testLog(): void {
    it('should throw an exception if the log level is invalid', function() {
      expect(function() { (new Logger)->log('dummy', 'Hello World!'); })->to->throw(InvalidParamException::class);
    });
  }
}

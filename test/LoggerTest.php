<?php declare(strict_types=1);
namespace yii\mustache;

use function PHPUnit\Expect\{expect, it};
use PHPUnit\Framework\{TestCase};
use yii\base\{InvalidArgumentException};

/** @testdox yii\mustache\Logger */
class LoggerTest extends TestCase {

  /** @testdox ->log() */
  function testLog(): void {
    it('should throw an exception if the log level is invalid', function() {
      expect(fn() => (new Logger)->log(666, 'Hello World!'))->to->throw(InvalidArgumentException::class);
    });
  }
}

<?php
declare(strict_types=1);
namespace yii\mustache;

use Psr\Log\{LoggerInterface, LoggerTrait, LogLevel};
use yii\base\{BaseObject, InvalidParamException};
use yii\log\{Logger as YiiLogger};

/**
 * Component used to log messages from the view engine to the application logger.
 */
class Logger extends BaseObject implements LoggerInterface {
  use LoggerTrait;

  /**
   * @var int[] Mappings between Mustache levels and Yii ones.
   */
  private static $levels = [
    LogLevel::ALERT => YiiLogger::LEVEL_ERROR,
    LogLevel::CRITICAL => YiiLogger::LEVEL_ERROR,
    LogLevel::DEBUG => YiiLogger::LEVEL_TRACE,
    LogLevel::EMERGENCY => YiiLogger::LEVEL_ERROR,
    LogLevel::ERROR => YiiLogger::LEVEL_ERROR,
    LogLevel::INFO => YiiLogger::LEVEL_INFO,
    LogLevel::NOTICE => YiiLogger::LEVEL_INFO,
    LogLevel::WARNING => YiiLogger::LEVEL_WARNING
  ];

  /**
   * Logs a message.
   * @param int $level The logging level.
   * @param string $message The message to be logged.
   * @param array $context The log context.
   * @throws InvalidParamException The specified logging level is unknown.
   */
  public function log($level, $message, array $context = []): void {
    if (!isset(static::$levels[$level])) {
      $values = implode(', ', (new \ReflectionClass(LogLevel::class))->getConstants());
      throw new InvalidParamException("Invalid enumerable value \"$level\". Please make sure it is among ($values).");
    }

    \Yii::getLogger()->log($message, static::$levels[$level], __METHOD__);
  }
}

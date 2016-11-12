<?php
/**
 * Implementation of the `yii\mustache\Logger` class.
 */
namespace yii\mustache;

use yii\base\{InvalidParamException};
use yii\log\{Logger as YiiLogger};

/**
 * Component used to log messages from the view engine to the application logger.
 */
class Logger extends \Mustache_Logger_AbstractLogger {

  /**
   * @var int[] Mappings between Mustache levels and Yii ones.
   */
  private static $levels = [
    \Mustache_Logger::ALERT => YiiLogger::LEVEL_ERROR,
    \Mustache_Logger::CRITICAL => YiiLogger::LEVEL_ERROR,
    \Mustache_Logger::DEBUG => YiiLogger::LEVEL_TRACE,
    \Mustache_Logger::EMERGENCY => YiiLogger::LEVEL_ERROR,
    \Mustache_Logger::ERROR => YiiLogger::LEVEL_ERROR,
    \Mustache_Logger::INFO => YiiLogger::LEVEL_INFO,
    \Mustache_Logger::NOTICE => YiiLogger::LEVEL_INFO,
    \Mustache_Logger::WARNING => YiiLogger::LEVEL_WARNING
  ];

  /**
   * Logs a message.
   * @param int $level The logging level.
   * @param string $message The message to be logged.
   * @param array $context The log context.
   * @throws InvalidParamException The specified logging level is unknown.
   */
  public function log($level, $message, array $context = []) {
    if (!isset(static::$levels[$level])) {
      $values = implode(', ', (new \ReflectionClass('\Mustache_Logger'))->getConstants());
      throw new InvalidParamException("Invalid enumerable value \"{$level}\". Please make sure it is among ({$values}).");
    }

    \Yii::getLogger()->log($message, static::$levels[$level], __METHOD__);
  }
}

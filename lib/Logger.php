<?php
/**
 * @file
 * Implementation of the `yii\mustache\Logger` class.
 */
namespace yii\mustache;

// Dependencies.
use yii\base\InvalidParamException;
use yii\log\Logger as YiiLogger;

/**
 * Component used to log messages from the view engine to the application logger.
 */
class Logger extends \Mustache_Logger_AbstractLogger {

  /**
   * @var array $levels
   * Mappings between Mustache levels and Yii ones.
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
   * @param $level The logging level.
   * @param $message The message to be logged.
   * @param $context The log context.
   * @throws yii::base::InvalidParamException The specified logging level is unknown.
   */
  public function log($level, $message, array $context = array()) {
    if(!isset(static::$levels[$level])) throw new InvalidParamException(\Yii::t(
      'yii',
      'Invalid enumerable value "{value}". Please make sure it is among ({enum}).',
      ['enum' => implode(', ', (new \ReflectionClass('\Mustache_Logger'))->getConstants()), 'value' => $level]
    ));

    \Yii::getLogger()->log($message, static::$levels[$level], __METHOD__);
  }
}

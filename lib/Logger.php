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
class Logger extends \Mustache_Logger_AbstractLogger implements \JsonSerializable {

  /**
   * Initializes a new instance of the class.
   * @param array $config Name-value pairs that will be used to initialize the object properties.
   */
  public function __construct(array $config = []) {
    foreach ($config as $property => $value) {
      $setter = "set{$property}";
      if (method_exists($this, $setter)) $this->$setter($value);
    }
  }

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
   * Converts this object to a map in JSON format.
   * @return \stdClass The map in JSON format corresponding to this object.
   */
  final public function jsonSerialize(): \stdClass {
    return $this->toJSON();
  }

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

  /**
   * Converts this object to a map in JSON format.
   * @return \stdClass The map in JSON format corresponding to this object.
   */
  public function toJSON(): \stdClass {
    return (object) [];
  }

  /**
   * Returns a string representation of this object.
   * @return string The string representation of this object.
   */
  public function __toString(): string {
    $json = json_encode($this, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    return static::class." {$json}";
  }
}

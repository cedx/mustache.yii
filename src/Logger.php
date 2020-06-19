<?php declare(strict_types=1);
namespace yii\mustache;

use Psr\Log\{LoggerInterface, LoggerTrait, LogLevel};
use yii\base\BaseObject;
use yii\log\Logger as YiiLogger;

/** Component used to log messages from the view engine to the application logger. */
class Logger extends BaseObject implements LoggerInterface {
	use LoggerTrait;

	/** @var int[] Mappings between Mustache levels and Yii ones. */
	private static array $levels = [
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
	 * @param array<string, mixed> $context The log context.
	 */
	function log($level, $message, array $context = []): void {
		assert(isset(self::$levels[$level]));
		\Yii::getLogger()->log($message, self::$levels[$level], __METHOD__);
	}
}

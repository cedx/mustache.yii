<?php declare(strict_types=1);
namespace yii\mustache\helpers;

use yii\base\{InvalidCallException, InvalidConfigException};
use yii\helpers\{ArrayHelper, StringHelper};
use yii\mustache\{Helper};

/**
 * Provides features related with internationalization (I18N) and localization (L10N).
 * @property \Closure $t A function translating a message.
 * @property \Closure $translate A function translating a message.
 */
class I18N extends Helper {

	/** @var string The default message category when no one is supplied. */
	public string $defaultCategory = "app";

	/**
	 * Returns a function translating a message.
	 * @return \Closure A function translating a message.
	 */
	function getT(): \Closure {
		return $this->getTranslate();
	}

	/**
	 * Returns a function translating a message.
	 * @return \Closure A function translating a message.
	 * @throws InvalidCallException The specified message has an invalid format.
	 */
	function getTranslate(): \Closure {
		return function($value, \Mustache_LambdaHelper $helper) {
			$defaultArgs = [
				"category" => $this->defaultCategory,
				"language" => null,
				"params" => []
			];

			$output = trim($value);
			$isJSON = StringHelper::startsWith($output, "{") && StringHelper::endsWith($output, "}");
			if ($isJSON) $args = $this->parseArguments($helper->render($value), "message", $defaultArgs);
			else {
				$parts = explode($this->argumentSeparator, $output, 2) ?: [];
				$length = count($parts);
				if (!$length) throw new InvalidCallException("Invalid translation format.");

				$args = ArrayHelper::merge($defaultArgs, [
					"category" => $length == 1 ? $this->defaultCategory : rtrim($parts[0]),
					"message" => $helper->render(ltrim($parts[$length - 1]))
				]);
			}

			return \Yii::t($args["category"], $args["message"], $args["params"], $args["language"]);
		};
	}

	/**
	 * Initializes this object.
	 * @throws InvalidConfigException The argument separator is empty.
	 */
	function init(): void {
		parent::init();
		if (!mb_strlen($this->defaultCategory)) throw new InvalidConfigException("The default message category is empty.");
	}
}

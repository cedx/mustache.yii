<?php declare(strict_types=1);
namespace yii\mustache\helpers;

use yii\helpers\{Html};
use yii\mustache\{Helper};

/**
 * Provides a set of commonly used data formatting methods.
 * @property \Closure $boolean A function formatting a value as boolean.
 * @property \Closure $currency A function formatting a value as currency number.
 * @property \Closure $date A function formatting a value as date.
 * @property \Closure $dateTime A function formatting a value as datetime.
 * @property \Closure $decimal A function formatting a value as decimal number.
 * @property \Closure $integer A function formatting a value as integer number without rounding.
 * @property \Closure $ntext A function formatting a value as HTML-encoded text with newlines converted into breaks.
 * @property \Closure $percent A function formatting a value as percent number.
 * @property \Closure $time A function formatting a value as time.
 */
class Format extends Helper {

	/**
	 * Returns a helper function formatting a value as boolean.
	 * @return \Closure A function formatting a value as boolean.
	 */
	function getBoolean(): \Closure {
		return function($value, \Mustache_LambdaHelper $helper) {
			$formatter = \Yii::$app->getFormatter();
			return $value === null ? $formatter->nullDisplay : Html::encode($formatter->asBoolean($helper->render($value)));
		};
	}

	/**
	 * Returns a helper function formatting a value as currency number.
	 * @return \Closure A function formatting a value as currency number.
	 */
	function getCurrency(): \Closure {
		return function($value, \Mustache_LambdaHelper $helper) {
			$formatter = \Yii::$app->getFormatter();
			if ($value === null) return $formatter->nullDisplay;
			$args = $this->parseArguments($helper->render($value), "value", ["currency" => null, "options" => [], "textOptions" => []]);
			return Html::encode($formatter->asCurrency($args["value"], $args["currency"], $args["options"], $args["textOptions"]));
		};
	}

	/**
	 * Returns a helper function formatting a value as date.
	 * @return \Closure A function formatting a value as date.
	 */
	function getDate(): \Closure {
		return function($value, \Mustache_LambdaHelper $helper) {
			$formatter = \Yii::$app->getFormatter();
			if ($value === null) return $formatter->nullDisplay;
			$args = $this->parseArguments($helper->render($value), "value", ["format" => null]);
			return Html::encode($formatter->asDate($args["value"], $args["format"]));
		};
	}

	/**
	 * Returns a helper function formatting a value as datetime.
	 * @return \Closure A function formatting a value as datetime.
	 */
	function getDateTime(): \Closure {
		return function($value, \Mustache_LambdaHelper $helper) {
			$formatter = \Yii::$app->getFormatter();
			if ($value === null) return $formatter->nullDisplay;
			$args = $this->parseArguments($helper->render($value), "value", ["format" => null]);
			return Html::encode($formatter->asDatetime($args["value"], $args["format"]));
		};
	}

	/**
	 * Returns a helper function formatting a value as decimal number.
	 * @return \Closure A function formatting a value as decimal number.
	 */
	function getDecimal(): \Closure {
		return function($value, \Mustache_LambdaHelper $helper) {
			$formatter = \Yii::$app->getFormatter();
			if ($value === null) return $formatter->nullDisplay;
			$args = $this->parseArguments($helper->render($value), "value", ["decimals" => null, "options" => [], "textOptions" => []]);
			return Html::encode($formatter->asDecimal($args["value"], $args["decimals"], $args["options"], $args["textOptions"]));
		};
	}

	/**
	 * Returns a helper function formatting a value as integer number by removing any decimal digits without rounding.
	 * @return \Closure A function formatting a value as integer number without rounding.
	 */
	function getInteger(): \Closure {
		return function($value, \Mustache_LambdaHelper $helper) {
			$formatter = \Yii::$app->getFormatter();
			if ($value === null) return $formatter->nullDisplay;
			$args = $this->parseArguments($helper->render($value), "value", ["options" => [], "textOptions" => []]);
			return Html::encode($formatter->asInteger($args["value"], $args["options"], $args["textOptions"]));
		};
	}

	/**
	 * Returns a helper function formatting a value as HTML-encoded plain text with newlines converted into breaks.
	 * @return \Closure A function formatting a value as HTML-encoded text with newlines converted into breaks.
	 */
	function getNtext(): \Closure {
		return fn($value, \Mustache_LambdaHelper $helper) =>
			$value === null ? \Yii::$app->getFormatter()->nullDisplay : preg_replace('/\r?\n/', "<br>", Html::encode($helper->render($value)));
	}

	/**
	 * Returns a helper function formatting a value as percent number with `%` sign.
	 * @return \Closure A function formatting a value as percent number.
	 */
	function getPercent(): \Closure {
		return function($value, \Mustache_LambdaHelper $helper) {
			$formatter = \Yii::$app->getFormatter();
			if ($value === null) return $formatter->nullDisplay;
			$args = $this->parseArguments($helper->render($value), "value", ["decimals" => null, "options" => [], "textOptions" => []]);
			return Html::encode($formatter->asPercent($args["value"], $args["decimals"], $args["options"], $args["textOptions"]));
		};
	}

	/**
	 * Returns a helper function formatting a value as time.
	 * @return \Closure A function formatting a value as time.
	 */
	function getTime(): \Closure {
		return function($value, \Mustache_LambdaHelper $helper) {
			$formatter = \Yii::$app->getFormatter();
			if ($value === null) return $formatter->nullDisplay;
			$args = $this->parseArguments($helper->render($value), "value", ["format" => null]);
			return Html::encode($formatter->asTime($args["value"], $args["format"]));
		};
	}
}

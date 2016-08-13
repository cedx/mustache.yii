<?php
/**
 * Implementation of the `yii\mustache\helpers\Format` class.
 */
namespace yii\mustache\helpers;
use yii\helpers\Html as HtmlHelper;

/**
 * Provides a set of commonly used data formatting methods.
 */
class Format extends Helper {

  /**
   * Returns a helper function formatting a value as boolean.
   * @return \Closure A function formatting a value as boolean.
   */
  public function getBoolean(): \Closure {
    return function($value, \Mustache_LambdaHelper $helper) {
      return HtmlHelper::encode(\Yii::$app->formatter->asBoolean($helper->render($value)));
    };
  }

  /**
   * Returns a helper function formatting a value as currency number.
   * @return \Closure A function formatting a value as currency number.
   */
  public function getCurrency(): \Closure {
    return function($value, \Mustache_LambdaHelper $helper) {
      $args = $this->parseArguments($helper->render($value), 'value', [
        'currency' => null,
        'options' => [],
        'textOptions' => []
      ]);

      return HtmlHelper::encode(\Yii::$app->formatter->asCurrency($args['value'], $args['currency'], $args['options'], $args['textOptions']));
    };
  }

  /**
   * Returns a helper function formatting a value as date.
   * @return \Closure A function formatting a value as date.
   */
  public function getDate(): \Closure {
    return function($value, \Mustache_LambdaHelper $helper) {
      $args = $this->parseArguments($helper->render($value), 'value', ['format' => null]);
      return HtmlHelper::encode(\Yii::$app->formatter->asDate($args['value'], $args['format']));
    };
  }

  /**
   * Returns a helper function formatting a value as datetime.
   * @return \Closure A function formatting a value as datetime.
   */
  public function getDateTime(): \Closure {
    return function($value, \Mustache_LambdaHelper $helper) {
      $args = $this->parseArguments($helper->render($value), 'value', ['format' => null]);
      return HtmlHelper::encode(\Yii::$app->formatter->asDatetime($args['value'], $args['format']));
    };
  }

  /**
   * Returns a helper function formatting a value as decimal number.
   * @return \Closure A function formatting a value as decimal number.
   */
  public function getDecimal(): \Closure {
    return function($value, \Mustache_LambdaHelper $helper) {
      $args = $this->parseArguments($helper->render($value), 'value', [
        'decimals' => null,
        'options' => [],
        'textOptions' => []
      ]);

      return HtmlHelper::encode(\Yii::$app->formatter->asDecimal($args['value'], $args['decimals'], $args['options'], $args['textOptions']));
    };
  }

  /**
   * Returns a helper function formatting a value as integer number by removing any decimal digits without rounding.
   * @return \Closure A function formatting a value as integer number without rounding.
   */
  public function getInteger(): \Closure {
    return function($value, \Mustache_LambdaHelper $helper) {
      $args = $this->parseArguments($helper->render($value), 'value', [
        'options' => [],
        'textOptions' => []
      ]);

      return HtmlHelper::encode(\Yii::$app->formatter->asInteger($args['value'], $args['options'], $args['textOptions']));
    };
  }

  /**
   * Returns a helper function formatting a value as HTML-encoded plain text with newlines converted into breaks.
   * @return \Closure A function formatting a value as HTML-encoded text with newlines converted into breaks.
   */
  public function getNtext(): \Closure {
    return function($value, \Mustache_LambdaHelper $helper) {
      if(!isset($value)) return \Yii::$app->formatter->nullDisplay;
      return preg_replace('/\r?\n/', '<br>', HtmlHelper::encode($helper->render($value)));
    };
  }

  /**
   * Returns a helper function formatting a value as percent number with `%` sign.
   * @return \Closure A function formatting a value as percent number.
   */
  public function getPercent(): \Closure {
    return function($value, \Mustache_LambdaHelper $helper) {
      $args = $this->parseArguments($helper->render($value), 'value', [
        'decimals' => null,
        'options' => [],
        'textOptions' => []
      ]);

      return HtmlHelper::encode(\Yii::$app->formatter->asPercent($args['value'], $args['decimals'], $args['options'], $args['textOptions']));
    };
  }

  /**
   * Returns a helper function formatting a value as time.
   * @return \Closure A function formatting a value as time.
   */
  public function getTime(): \Closure {
    return function($value, \Mustache_LambdaHelper $helper) {
      $args = $this->parseArguments($helper->render($value), 'value', ['format' => null]);
      return HtmlHelper::encode(\Yii::$app->formatter->asTime($args['value'], $args['format']));
    };
  }
}

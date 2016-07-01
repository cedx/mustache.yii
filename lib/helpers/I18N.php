<?php
/**
 * Implementation of the `yii\mustache\helpers\I18N` class.
 */
namespace yii\mustache\helpers;

// Module dependencies.
use yii\base\InvalidCallException;
use yii\helpers\ArrayHelper;

/**
 * Provides features related with internationalization (I18N) and localization (L10N).
 */
class I18N extends Helper {

  /**
   * @var string The default message category when no one is supplied.
   */
  public $defaultCategory = 'app';

  /**
   * Returns a function translating a message.
   * @return \Closure A function translating a message.
   */
  public function getT(): \Closure {
    return static::getTranslate();
  }

  /**
   * Returns a function translating a message.
   * @return \Closure A function translating a message.
   * @throws InvalidCallException The specified message has an invalid format.
   */
  public function getTranslate(): \Closure {
    return function($value, \Mustache_LambdaHelper $helper) {
      $defaultArgs = [
        'category' => $this->defaultCategory,
        'language' => null,
        'params' => []
      ];

      $output = trim($value);
      $isJson = (mb_substr($output, 0, 1) == '{' && mb_substr($output, mb_strlen($output)-1) == '}');

      if($isJson) $args = $this->parseArguments($helper->render($value), 'message', $defaultArgs);
      else {
        $parts = explode($this->argumentSeparator, $output, 2);

        $length = count($parts);
        if(!$length) throw new InvalidCallException(\Yii::t('yii', 'Invalid translation format.'));

        $args = ArrayHelper::merge($defaultArgs, [
          'category' => $length == 1 ? $this->defaultCategory : $parts[0],
          'message' => $parts[$length-1]
        ]);
      }

      return \Yii::t($args['category'], $args['message'], $args['params'], $args['language']);
    };
  }
}

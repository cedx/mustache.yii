<?php
/**
 * Implementation of the `yii\mustache\helpers\I18N` class.
 * @module helpers.I18N
 */
namespace yii\mustache\helpers;

// Module dependencies.
use yii\base\InvalidCallException;
use yii\helpers\ArrayHelper;

/**
 * Provides features related with internationalization (I18N) and localization (L10N).
 * @class yii.mustache.helpers.I18N
 * @extends mustache.helpers.Helper
 * @constructor
 */
class I18N extends Helper {

  /**
   * Translates a message.
   * See: `getTranslate()`
   * @property t
   * @type Closure
   * @final
   */
  public function getT() {
    return static::getTranslate();
  }

  /**
   * Translates a message.
   * See: `Yii::t()`
   * @property translate
   * @type Closure
   * @final
   * @throws {yii.base.InvalidCallException} The specified message has an invalid format.
   */
  public function getTranslate() {
    return function($value, \Mustache_LambdaHelper $helper) {
      $defaultArgs=[
        'category'=>'app',
        'language'=>null,
        'params'=>[]
      ];

      $output=trim($value);
      $isJson=(mb_substr($output, 0, 1)=='{' && mb_substr($output, mb_strlen($output)-1)=='}');

      if($isJson) $args=$this->parseArguments($helper->render($value), 'message', $defaultArgs);
      else {
        $parts=explode($this->argumentSeparator, $output, 2);
        if(count($parts)!=2) throw new InvalidCallException(\Yii::t('yii', 'Invalid translation format.'));
        $args=ArrayHelper::merge($defaultArgs, [
          'category'=>$parts[0],
          'message'=>$parts[1]
        ]);
      }

      return \Yii::t($args['category'], $args['message'], $args['params'], $args['language']);
    };
  }
}

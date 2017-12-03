<?php
declare(strict_types=1);
namespace yii\mustache\helpers;

use yii\base\{InvalidCallException, InvalidConfigException};
use yii\helpers\{ArrayHelper};
use yii\mustache\{Helper};

/**
 * Provides features related with internationalization (I18N) and localization (L10N).
 * @property \Closure $t A function translating a message.
 * @property \Closure $translate A function translating a message.
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
      $isJSON = mb_substr($output, 0, 1) == '{' && mb_substr($output, mb_strlen($output) - 1) == '}';

      if ($isJSON) $args = $this->parseArguments($helper->render($value), 'message', $defaultArgs);
      else {
        $parts = explode($this->argumentSeparator, $output, 2);
        $length = count($parts);
        if (!$length) throw new InvalidCallException('Invalid translation format.');

        $args = ArrayHelper::merge($defaultArgs, [
          'category' => $length == 1 ? $this->defaultCategory : rtrim($parts[0]),
          'message' => ltrim($parts[$length - 1])
        ]);
      }

      return \Yii::t($args['category'], $args['message'], $args['params'], $args['language']);
    };
  }

  /**
   * Initializes the object.
   * @throws InvalidConfigException The argument separator is empty.
   */
  public function init(): void {
    parent::init();
    if (!mb_strlen($this->defaultCategory)) throw new InvalidConfigException('The argument separator is empty.');
  }
}

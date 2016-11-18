<?php
/**
 * Implementation of the `yii\mustache\helpers\I18N` class.
 */
namespace yii\mustache\helpers;

use yii\base\{InvalidCallException};
use yii\helpers\{ArrayHelper};
use yii\mustache\{Helper};

/**
 * Provides features related with internationalization (I18N) and localization (L10N).
 */
class I18N extends Helper {

  /**
   * @var string The default message category when no one is supplied.
   */
  private $defaultCategory = 'app';

  /**
   * Gets the default message category when no one is supplied.
   * @return string The default message category.
   */
  public function getDefaultCategory(): string {
    return $this->defaultCategory;
  }

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
      $defaultCategory = $this->getDefaultCategory();

      $defaultArgs = [
        'category' => $defaultCategory,
        'language' => null,
        'params' => []
      ];

      $output = trim($value);
      $isJSON = mb_substr($output, 0, 1) == '{' && mb_substr($output, mb_strlen($output) - 1) == '}';

      if ($isJSON) $args = $this->parseArguments($helper->render($value), 'message', $defaultArgs);
      else {
        $parts = explode($this->getArgumentSeparator(), $output, 2);
        $length = count($parts);
        if (!$length) throw new InvalidCallException('Invalid translation format.');

        $args = ArrayHelper::merge($defaultArgs, [
          'category' => $length == 1 ? $defaultCategory : $parts[0],
          'message' => $parts[$length - 1]
        ]);
      }

      return \Yii::t($args['category'], $args['message'], $args['params'], $args['language']);
    };
  }

  /**
   * Sets the default message category when no one is supplied.
   * @param string $value The new default message category.
   * @return I18N This instance.
   */
  public function setDefaultCategory(string $value): self {
    $this->defaultCategory = $value;
    return $this;
  }

  /**
   * Converts this object to a map in JSON format.
   * @return \stdClass The map in JSON format corresponding to this object.
   */
  public function toJSON(): \stdClass {
    $map = parent::toJSON();
    $map->defaultCategory = $this->getDefaultCategory();
    return $map;
  }
}

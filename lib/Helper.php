<?php
/**
 * Implementation of the `yii\mustache\Helper` class.
 */
namespace yii\mustache;

use yii\base\{InvalidParamException, Object};
use yii\helpers\{ArrayHelper, Json};

/**
 * Provides the abstract base class for a view helper.
 */
abstract class Helper extends Object {

  /**
   * @var string String used to separate the arguments for helpers supporting the "two arguments" syntax.
   */
  private $argumentSeparator = ':';

  /**
   * Gets the string used to separate the arguments for helpers supporting the "two arguments" syntax.
   * @return string The string used to separate helper arguments.
   */
  public function getArgumentSeparator(): string {
    return $this->argumentSeparator;
  }

  /**
   * Sets the string used to separate the arguments for helpers supporting the "two arguments" syntax.
   * @param string $value The new string to use to separate the helper arguments.
   * @return Helper This instance.
   */
  public function setArgumentSeparator(string $value): self {
    $this->argumentSeparator = $value;
    return $this;
  }
  /**
  /**
   * Returns the output sent by the call of the specified function.
   * @param callable $callback The function to invoke.
   * @return string The captured output.
   */
  protected function captureOutput(callable $callback): string {
    ob_start();
    call_user_func($callback);
    return ob_get_clean();
  }

  /**
   * Parses the arguments of a parametrized helper.
   * Arguments can be specified as a single value, or as a string in JSON format.
   * @param string $text The section content specifying the helper arguments.
   * @param string $defaultArgument The name of the default argument. This is used when the section content provides a plain string instead of a JSON object.
   * @param array $defaultValues The default values of arguments. These are used when the section content does not specify all arguments.
   * @return array The parsed arguments as an associative array.
   */
  protected function parseArguments(string $text, string $defaultArgument, array $defaultValues = []): array {
    try {
      if (is_array($json = Json::decode($text))) return ArrayHelper::merge($defaultValues, $json);
      throw new InvalidParamException();
    }

    catch (InvalidParamException $e) {
      $defaultValues[$defaultArgument] = $text;
      return $defaultValues;
    }
  }
}

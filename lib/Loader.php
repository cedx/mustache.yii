<?php
/**
 * Implementation of the `yii\mustache\Loader` class.
 */
namespace yii\mustache;

use yii\base\{InvalidCallException, InvalidParamException, Object};
use yii\helpers\{FileHelper};

/**
 * Loads views from the file system.
 */
class Loader extends Object implements \JsonSerializable, \Mustache_Loader {

  /**
   * @var string The string prefixed to every cache key in order to avoid name collisions.
   */
  const CACHE_KEY_PREFIX = __CLASS__;

  /**
   * @var string The default extension of template files.
   */
  const DEFAULT_EXTENSION = 'mustache';

  /**
   * @var ViewRenderer The instance used to render the views.
   */
  private $viewRenderer;

  /**
   * @var string[] The loaded views.
   */
  private $views = [];

  /**
   * Returns a string representation of this object.
   * @return string The string representation of this object.
   */
  public function __toString(): string {
    $json = json_encode($this, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    return static::class." $json";
  }

  /**
   * Gets the instance used to render the views.
   * @return ViewRenderer The instance used to render the views.
   */
  public function getViewRenderer() {
    return $this->viewRenderer;
  }

  /**
   * Converts this object to a map in JSON format.
   * @return \stdClass The map in JSON format corresponding to this object.
   */
  public function jsonSerialize(): \stdClass {
    return (object) [
      'viewRenderer' => ($viewRenderer = $this->getViewRenderer()) ? get_class($viewRenderer) : null
    ];
  }

  /**
   * Loads the view with the specified name.
   * @param string $name The view name.
   * @return string The view contents.
   * @throws InvalidCallException Unable to locate the view file.
   */
  public function load($name): string {
    if (!isset($this->views[$name])) {
      $viewRenderer = $this->getViewRenderer();
      $cacheId = $viewRenderer->getCacheId();

      $cache = mb_strlen($cacheId) ? \Yii::$app->get($cacheId) : null;
      $cacheKey = static::CACHE_KEY_PREFIX.":$name";
      if ($cache && $cache->exists($cacheKey)) $output = $cache[$cacheKey];
      else {
        $path = FileHelper::localize($this->findViewFile($name));
        if (!is_file($path)) throw new InvalidCallException("The view file \"$path\" does not exist.");

        $output = @file_get_contents($path);
        if ($cache) $cache->set($cacheKey, $output, $viewRenderer->getCachingDuration());
      }

      $this->views[$name] = $output;
    }

    return $this->views[$name];
  }

  /**
   * Sets the instance used to render the views.
   * @param ViewRenderer $value The instance used to render the views.
   * @return Loader This instance.
   */
  public function setViewRenderer(ViewRenderer $value = null): self {
    $this->viewRenderer = $value;
    return $this;
  }

  /**
   * Finds the view file based on the given view name.
   * @param string $name The view name.
   * @return string The view file path.
   * @throws \BadMethodCallException Unable to locate the view file.
   */
  protected function findViewFile(string $name): string {
    if (!mb_strlen($name)) throw new InvalidParamException('The view name is empty.');

    $appViewPath = \Yii::$app->getViewPath();
    $controller = \Yii::$app->controller;

    if (mb_substr($name, 0, 2) == '//') $file = $appViewPath.DIRECTORY_SEPARATOR.ltrim($name, '/');
    else if ($name[0] == '/') {
      if (!$controller) throw new InvalidCallException("Unable to locate the view \"$name\": no active controller.");
      $file = $controller->module->getViewPath().DIRECTORY_SEPARATOR.ltrim($name, '/');
    }
    else {
      $viewPath = $controller ? $controller->getViewPath() : $appViewPath;
      $file = \Yii::getAlias("$viewPath/$name");
    }

    $view = \Yii::$app->getView();
    if ($view && $view->theme) $file = $view->theme->applyTo($file);
    if (!mb_strlen(pathinfo($file, PATHINFO_EXTENSION))) $file .= '.'.($view ? $view->defaultExtension : static::DEFAULT_EXTENSION);
    return $file;
  }
}

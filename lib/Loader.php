<?php
namespace yii\mustache;

use yii\base\{InvalidCallException, InvalidConfigException, InvalidParamException, Object};
use yii\helpers\{FileHelper};

/**
 * Loads views from the file system.
 */
class Loader extends Object implements \Mustache_Loader {

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
  public $viewRenderer;

  /**
   * @var string[] The loaded views.
   */
  private $views = [];

  /**
   * Initializes the object.
   * @throws InvalidConfigException The view renderer is not initialized.
   */
  public function init() {
    parent::init();
    if (!$this->viewRenderer instanceof ViewRenderer) throw new InvalidConfigException('The view renderer is not initialized.');
  }

  /**
   * Loads the view with the specified name.
   * @param string $name The view name.
   * @return string The view contents.
   * @throws InvalidCallException Unable to locate the view file.
   */
  public function load($name): string {
    if (!isset($this->views[$name])) {
      $cacheId = $this->viewRenderer->cacheId;

      $cache = mb_strlen($cacheId) ? \Yii::$app->get($cacheId) : null;
      $cacheKey = static::CACHE_KEY_PREFIX.":$name";
      if ($cache && $cache->exists($cacheKey)) $output = $cache[$cacheKey];
      else {
        $path = FileHelper::localize($this->findViewFile($name));
        if (!is_file($path)) throw new InvalidCallException("The view file \"$path\" does not exist.");

        $output = @file_get_contents($path);
        if ($cache) $cache->set($cacheKey, $output, $this->viewRenderer->cachingDuration);
      }

      $this->views[$name] = $output;
    }

    return $this->views[$name];
  }

  /**
   * Finds the view file based on the given view name.
   * @param string $name The view name.
   * @return string The view file path.
   * @throws \BadMethodCallException Unable to locate the view file.
   */
  protected function findViewFile(string $name): string {
    if (!mb_strlen($name)) throw new InvalidParamException('The view name is empty.');

    $controller = \Yii::$app->controller;

    if (mb_substr($name, 0, 2) == '//') $file = \Yii::$app->viewPath.DIRECTORY_SEPARATOR.ltrim($name, '/');
    else if ($name[0] == '/') {
      if (!$controller) throw new InvalidCallException("Unable to locate the view \"$name\": no active controller.");
      $file = $controller->module->viewPath.DIRECTORY_SEPARATOR.ltrim($name, '/');
    }
    else {
      $viewPath = $controller ? $controller->viewPath : \Yii::$app->viewPath;
      $file = \Yii::getAlias("$viewPath/$name");
    }

    $view = \Yii::$app->view;
    if ($view && $view->theme) $file = $view->theme->applyTo($file);
    if (!mb_strlen(pathinfo($file, PATHINFO_EXTENSION))) $file .= '.'.($view ? $view->defaultExtension : static::DEFAULT_EXTENSION);
    return $file;
  }
}

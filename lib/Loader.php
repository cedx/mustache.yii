<?php declare(strict_types=1);
namespace yii\mustache;

use yii\base\{BaseObject, InvalidConfigException, View, ViewNotFoundException};
use yii\helpers\{FileHelper};

/** Loads views from the file system. */
class Loader extends BaseObject implements \Mustache_Loader {

  /** @var ViewRenderer The instance used to render the views. */
  public ViewRenderer $viewRenderer;

  /** @var string[] The loaded views. */
  private array $views = [];

  /**
   * Initializes this object.
   * @throws InvalidConfigException The view renderer is not initialized.
   */
  function init(): void {
    parent::init();
    if (!$this->viewRenderer instanceof ViewRenderer) throw new InvalidConfigException('The view renderer is not initialized.');
  }

  /**
   * Loads the view with the specified name.
   * @param string $name The view name.
   * @return string The view contents.
   * @throws ViewNotFoundException Unable to locate the view file.
   */
  function load($name): string {
    static $findViewFile;
    if (!isset($findViewFile)) {
      $findViewFile = (new \ReflectionClass(View::class))->getMethod('findViewFile');
      $findViewFile->setAccessible(true);
    }

    if (!isset($this->views[$name])) {
      /** @var \yii\caching\Cache $cache */
      $cache = $this->viewRenderer->cache;
      $cacheKey = [__METHOD__, $name];

      if ($this->viewRenderer->enableCaching && $cache->exists($cacheKey)) $output = $cache->get($cacheKey);
      else {
        /** @var View $view */
        $view = $this->viewRenderer->view;
        $path = $findViewFile->invoke($view, $name, $view->context);
        if ($view->theme) {
          /** @var \yii\base\Theme $theme */
          $theme = $view->theme;
          $path = $theme->applyTo($path);
        }

        if (!is_file($path)) throw new ViewNotFoundException("The view file does not exist: $path");
        $output = (string) @file_get_contents(FileHelper::localize($path));
        if ($this->viewRenderer->enableCaching) $cache->set($cacheKey, $output, $this->viewRenderer->cachingDuration);
      }

      $this->views[$name] = $output;
    }

    return $this->views[$name];
  }
}

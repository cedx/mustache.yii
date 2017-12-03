<?php
declare(strict_types=1);
namespace yii\mustache;

use yii\base\{BaseObject, InvalidConfigException};

/**
 * Component used to store compiled views to a cache application component.
 */
class Cache extends BaseObject implements \Mustache_Cache {

  /**
   * @var ViewRenderer The instance used to render the views.
   */
  public $viewRenderer;

  /**
   * Caches and loads a compiled view.
   * @param string $key The key identifying the view to be cached.
   * @param string $value The view to be cached.
   */
  public function cache($key, $value): void {
    $viewRenderer = $this->viewRenderer;
    if (!$viewRenderer->enableCaching) eval("?>$value");
    else {
      $viewRenderer->cache->set([__CLASS__, $key], $value, $viewRenderer->cachingDuration);
      $this->load($key);
    }
  }

  /**
   * Initializes the object.
   * @throws InvalidConfigException The view renderer is not initialized.
   */
  public function init(): void {
    parent::init();
    if (!$this->viewRenderer instanceof ViewRenderer) throw new InvalidConfigException('The view renderer is not initialized.');
  }

  /**
   * Loads a compiled view from cache.
   * @param string $key The key identifying the view to be loaded.
   * @return bool `true` if the view was successfully loaded, otherwise `false`.
   */
  public function load($key): bool {
    $cacheKey = [__CLASS__, $key];
    $viewRenderer = $this->viewRenderer;
    if (!$viewRenderer->enableCaching || !$viewRenderer->cache->exists($cacheKey)) return false;

    $code = $viewRenderer->cache->get($cacheKey);
    eval("?>$code");
    return true;
  }
}

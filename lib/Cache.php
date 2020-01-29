<?php declare(strict_types=1);
namespace yii\mustache;

use yii\base\{BaseObject, InvalidConfigException};

/** Component used to store compiled views to a cache application component. */
class Cache extends BaseObject implements \Mustache_Cache {

  /** @var ViewRenderer The instance used to render the views. */
  public ViewRenderer $viewRenderer;

  /**
   * Caches and loads a compiled view.
   * @param string $key The key identifying the view to be cached.
   * @param string $value The view to be cached.
   */
  function cache($key, $value): void {
    assert(is_string($key) && mb_strlen($key) > 0);
    if (!$this->viewRenderer->enableCaching) eval("?>$value");
    else {
      /** @var \yii\caching\Cache $cache */
      $cache = $this->viewRenderer->cache;
      $cache->set([__CLASS__, $key], $value, $this->viewRenderer->cachingDuration);
      $this->load($key);
    }
  }

  /**
   * Initializes this object.
   * @throws InvalidConfigException The view renderer is not initialized.
   */
  function init(): void {
    parent::init();
    if (!$this->viewRenderer instanceof ViewRenderer) throw new InvalidConfigException('The view renderer is not initialized.');
  }

  /**
   * Loads a compiled view from cache.
   * @param string $key The key identifying the view to be loaded.
   * @return bool `true` if the view was successfully loaded, otherwise `false`.
   */
  function load($key): bool {
    assert(is_string($key) && mb_strlen($key) > 0);
    $cacheKey = [__CLASS__, $key];

    /** @var \yii\caching\Cache $cache */
    $cache = $this->viewRenderer->cache;
    if (!$this->viewRenderer->enableCaching || !$cache->exists($cacheKey)) return false;

    eval("?>{$cache->get($cacheKey)}");
    return true;
  }
}

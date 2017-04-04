<?php
namespace yii\mustache;
use yii\base\{Object};

/**
 * Component used to store compiled views to a cache application component.
 */
class Cache extends Object implements \Mustache_Cache {

  /**
   * @var string The string prefixed to every cache key in order to avoid name collisions.
   */
  const CACHE_KEY_PREFIX = __CLASS__;

  /**
   * @var ViewRenderer The instance used to render the views.
   */
  public $viewRenderer;

  /**
   * Caches and loads a compiled view.
   * @param string $key The key identifying the view to be cached.
   * @param string $value The view to be cached.
   */
  public function cache($key, $value) {
    $cacheId = $this->viewRenderer->cacheId;

    $cache = mb_strlen($cacheId) ? \Yii::$app->get($cacheId) : null;
    if (!$cache) eval("?>$value");
    else {
      $cache->set(static::CACHE_KEY_PREFIX.":$key", $value, $this->viewRenderer->cachingDuration);
      $this->load($key);
    }
  }

  /**
   * Loads a compiled view from cache.
   * @param string $key The key identifying the view to be loaded.
   * @return bool `true` if the view was successfully loaded, otherwise `false`.
   */
  public function load($key): bool {
    $cacheId = $this->viewRenderer->cacheId;

    $cache = mb_strlen($cacheId) ? \Yii::$app->get($cacheId) : null;
    $cacheKey = static::CACHE_KEY_PREFIX.":$key";
    if (!$cache || !$cache->exists($cacheKey)) return false;

    eval("?>{$cache[$cacheKey]}");
    return true;
  }
}

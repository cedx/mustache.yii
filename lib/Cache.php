<?php
/**
 * Implementation of the `yii\mustache\Cache` class.
 */
namespace yii\mustache;

/**
 * Component used to store compiled views to a cache application component.
 */
class Cache extends \Mustache_Cache_AbstractCache {

  /**
   * @var string The string prefixed to every cache key in order to avoid name collisions.
   */
  const CACHE_KEY_PREFIX = __CLASS__;

  /**
   * @var ViewRenderer The instance used to render the views.
   */
  private $renderer;

  /**
   * Initializes a new instance of the class.
   * @param ViewRenderer $renderer The instance used to render the views.
   */
  public function __construct(ViewRenderer $renderer) {
    $this->renderer = $renderer;
  }

  /**
   * Caches and loads a compiled view.
   * @param string $key The key identifying the view to be cached.
   * @param string $value The view to be cached.
   */
  public function cache($key, $value) {
    $cache = $this->renderer->cacheId ? \Yii::$app->get($this->renderer->cacheId) : null;
    if (!$cache) eval('?>' . $value);
    else {
      $cache->set(static::CACHE_KEY_PREFIX . $key, $value, $this->renderer->cachingDuration);
      $this->load($key);
    }
  }

  /**
   * Loads a compiled view from cache.
   * @param string $key The key identifying the view to be loaded.
   * @return bool `true` if the view was successfully loaded, otherwise `false`.
   */
  public function load($key): bool {
    $cache = $this->renderer->cacheId ? \Yii::$app->get($this->renderer->cacheId) : null;
    $key = static::CACHE_KEY_PREFIX . $key;
    if (!$cache || !$cache->exists($key)) return false;

    eval('?>' . $cache[$key]);
    return true;
  }
}

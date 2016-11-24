<?php
/**
 * Implementation of the `yii\mustache\Cache` class.
 */
namespace yii\mustache;

/**
 * Component used to store compiled views to a cache application component.
 */
class Cache extends \Mustache_Cache_AbstractCache implements \JsonSerializable {

  /**
   * @var string The string prefixed to every cache key in order to avoid name collisions.
   */
  const CACHE_KEY_PREFIX = __CLASS__;

  /**
   * @var ViewRenderer The instance used to render the views.
   */
  private $viewRenderer;

  /**
   * Initializes a new instance of the class.
   * @param array $config Name-value pairs that will be used to initialize the object properties.
   */
  public function __construct(array $config = []) {
    foreach ($config as $property => $value) {
      $setter = "set{$property}";
      if (method_exists($this, $setter)) $this->$setter($value);
    }
  }

  /**
   * Returns a string representation of this object.
   * @return string The string representation of this object.
   */
  public function __toString(): string {
    $json = json_encode($this, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    return static::class." {$json}";
  }

  /**
   * Caches and loads a compiled view.
   * @param string $key The key identifying the view to be cached.
   * @param string $value The view to be cached.
   */
  public function cache($key, $value) {
    $viewRenderer = $this->getViewRenderer();
    $cacheId = $viewRenderer->getCacheId();

    $cache = mb_strlen($cacheId) ? \Yii::$app->get($cacheId) : null;
    if (!$cache) eval("?>{$value}");
    else {
      $cache->set(static::CACHE_KEY_PREFIX.":$key", $value, $viewRenderer->getCachingDuration());
      $this->load($key);
    }
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
      'logger' => ($logger = $this->getLogger()) ? get_class($logger) : null,
      'viewRenderer' => ($viewRenderer = $this->getViewRenderer()) ? get_class($viewRenderer) : null
    ];
  }

  /**
   * Loads a compiled view from cache.
   * @param string $key The key identifying the view to be loaded.
   * @return bool `true` if the view was successfully loaded, otherwise `false`.
   */
  public function load($key): bool {
    $viewRenderer = $this->getViewRenderer();
    $cacheId = $viewRenderer->getCacheId();

    $cache = mb_strlen($cacheId) ? \Yii::$app->get($cacheId) : null;
    $cacheKey = static::CACHE_KEY_PREFIX.":$key";
    if (!$cache || !$cache->exists($cacheKey)) return false;

    eval("?>{$cache[$cacheKey]}");
    return true;
  }

  /**
   * Sets the instance used to render the views.
   * @param ViewRenderer $value The instance used to render the views.
   * @return Cache This instance.
   */
  public function setViewRenderer(ViewRenderer $value = null): self {
    $this->viewRenderer = $value;
    return $this;
  }
}

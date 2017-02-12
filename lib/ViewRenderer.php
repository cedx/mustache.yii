<?php
/**
 * Implementation of the `yii\mustache\ViewRenderer` class.
 */
namespace yii\mustache;

use yii\base\{InvalidCallException};
use yii\helpers\{ArrayHelper, FileHelper, Html};

/**
 * View renderer allowing to use the [Mustache](http://mustache.github.io) template syntax.
 */
class ViewRenderer extends \yii\base\ViewRenderer implements \JsonSerializable {

  /**
   * @var string The string prefixed to every cache key in order to avoid name collisions.
   */
  const CACHE_KEY_PREFIX = __CLASS__;

  /**
   * @var string The identifier of the cache application component that is used to cache the compiled views. If empty, the caching is disabled.
   */
  private $cacheId = '';

  /**
   * @var int The time in seconds that the compiled views can remain valid in cache. If set to `0`, the cache never expires.
   */
  private $cachingDuration = 0;

  /**
   * @var bool Value indicating whether to enable the logging of engine messages.
   */
  private $enableLogging = false;

  /**
   * @var \Mustache_Engine The underlying Mustache template engine.
   */
  private $engine;

  /**
   * @var array The values prepended to the context stack.
   */
  private $helpers = [];

  /**
   * Returns a string representation of this object.
   * @return string The string representation of this object.
   */
  public function __toString(): string {
    $json = json_encode($this, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    return static::class." $json";
  }

  /**
   * Gets a value indicating whether to enable the logging of engine messages.
   * @return bool `true` to enable the logging of engine messages, otherwise `false`.
   */
  public function enableLogging(): bool {
    return $this->enableLogging;
  }

  /**
   * Gets the identifier of the cache application component that is used to cache the compiled views.
   * @return string The identifier of the cache application component.
   */
  public function getCacheId(): string {
    return $this->cacheId;
  }

  /**
   * Gets the time in seconds that the compiled views can remain valid in cache.
   * @return int The time in seconds that the compiled views can remain valid in cache.
   */
  public function getCachingDuration(): int {
    return $this->cachingDuration;
  }

  /**
   * Gets the values prepended to the context stack, so they will be available in any view loaded by this instance.
   * @return \Mustache_HelperCollection The list of the values prepended to the context stack. Always `null` until the component is fully initialized.
   */
  public function getHelpers() {
    return $this->engine ? $this->engine->getHelpers() : null;
  }

  /**
   * Converts this object to a map in JSON format.
   * @return \stdClass The map in JSON format corresponding to this object.
   */
  public function jsonSerialize(): \stdClass {
    return (object) [
      'cacheId' => $this->getCacheId(),
      'cachingDuration' => $this->getCachingDuration(),
      'enableLogging' => $this->enableLogging()
    ];
  }

  /**
   * Initializes the application component.
   */
  public function init() {
    $helpers = [
      'app' => \Yii::$app,
      'format' => \Yii::createObject(helpers\Format::class),
      'html' => \Yii::createObject(helpers\HTML::class),
      'i18n' => \Yii::createObject(helpers\I18N::class),
      'url' => \Yii::createObject(helpers\URL::class),
      'yii' => [
        'debug' => YII_DEBUG,
        'devEnv' => YII_ENV_DEV,
        'prodEnv' => YII_ENV_PROD,
        'testEnv' => YII_ENV_TEST
      ]
    ];

    $options = [
      'cache' => \Yii::createObject(Cache::class, [$this]),
      'charset' => \Yii::$app->charset,
      'entity_flags' => ENT_QUOTES | ENT_SUBSTITUTE,
      'escape' => [Html::class, 'encode'],
      'helpers' => ArrayHelper::merge($helpers, $this->helpers),
      'partials_loader' => \Yii::createObject(['class' => Loader::class, 'viewRenderer' => $this]),
      'strict_callables' => true
    ];

    if ($this->enableLogging()) $options['logger'] = \Yii::createObject(Logger::class);
    $this->engine = \Yii::createObject(\Mustache_Engine::class, [$options]);

    parent::init();
    $this->helpers = [];
  }

  /**
   * Renders a view file.
   * @param \yii\base\View $view The view object used for rendering the file.
   * @param string $file The view file.
   * @param array $params The parameters to be passed to the view file.
   * @return string The rendering result.
   * @throws InvalidCallException The specified view file is not found.
   */
  public function render($view, $file, $params): string {
    $cacheId = $this->getCacheId();
    $cache = mb_strlen($cacheId) ? \Yii::$app->get($cacheId) : null;

    $cacheKey = static::CACHE_KEY_PREFIX.":$file";
    if ($cache && $cache->exists($cacheKey))
      $output = $cache[$cacheKey];
    else {
      $path = FileHelper::localize($file);
      if (!is_file($path)) throw new InvalidCallException("View file \"$file\" does not exist.");

      $output = @file_get_contents($path);
      if ($cache) $cache->set($cacheKey, $output, $this->getCachingDuration());
    }

    $values = ArrayHelper::merge(['this' => $view], is_array($params) ? $params : []);
    return $this->engine->render($output, $values);
  }

  /**
   * Sets the identifier of the cache application component that is used to cache the compiled views.
   * @param string $value The identifier of the cache application component. If empty, the caching is disabled.
   * @return ViewRenderer This instance.
   */
  public function setCacheId(string $value): self {
    $this->cacheId = $value;
    return $this;
  }

  /**
   * Sets the time in seconds that the compiled views can remain valid in cache.
   * @param int $value The time in seconds that the compiled views can remain valid in cache. If set to `0`, the cache never expires.
   * @return ViewRenderer This instance.
   */
  public function setCachingDuration(int $value): self {
    $this->cachingDuration = $value;
    return $this;
  }

  /**
   * Sets a value indicating whether to enable the logging of engine messages.
   * @param bool $value `true` to enable the logging of engine messages, otherwise `false`.
   * @return ViewRenderer This instance.
   */
  public function setEnableLogging(bool $value): self {
    $this->enableLogging = $value;
    return $this;
  }

  /**
   * Sets the values to prepend to the context stack, so they will be available in any view loaded by this instance.
   * @param array $value The list of the values to prepend to the context stack.
   * @return ViewRenderer This instance.
   */
  public function setHelpers(array $value): self {
    if ($this->engine) $this->engine->setHelpers($value);
    else $this->helpers = $value;
    return $this;
  }
}

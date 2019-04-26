<?php declare(strict_types=1);
namespace yii\mustache;

use yii\base\{InvalidCallException};
use yii\di\{Instance};
use yii\helpers\{ArrayHelper, FileHelper, Html};

/**
 * View renderer allowing to use the [Mustache](https://mustache.github.io) template syntax.
 * @property \Mustache_HelperCollection $helpers The list of the values prepended to the context stack. Always `null` until the component is fully initialized.
 */
class ViewRenderer extends \yii\base\ViewRenderer {

  /** @var array|string|\yii\caching\CacheInterface The cache object or the application component ID of the cache object. */
  public $cache = 'cache';

  /** @var int The time in seconds that the compiled views can remain valid in cache. If set to `0`, the cache never expires. */
  public $cachingDuration = 0;

  /** @var bool Value indicating whether to enable caching view templates. */
  public $enableCaching = false;

  /** @var bool Value indicating whether to enable logging engine messages. */
  public $enableLogging = false;

  /** @var \Mustache_Engine|null The underlying Mustache template engine. */
  private $engine;

  /** @var array The values prepended to the context stack. */
  private $helpers = [];

  /**
   * Gets the values prepended to the context stack, so they will be available in any view loaded by this instance.
   * @return \Mustache_HelperCollection|null The list of the values prepended to the context stack. Always `null` until the component is fully initialized.
   */
  function getHelpers(): ?\Mustache_HelperCollection {
    return $this->engine ? $this->engine->getHelpers() : null;
  }

  /** Initializes the application component.*/
  function init(): void {
    $helpers = [
      'app' => \Yii::$app,
      'format' => new helpers\Format,
      'html' => new helpers\Html,
      'i18n' => new helpers\I18N,
      'url' => new helpers\Url
    ];

    $options = [
      'charset' => \Yii::$app->charset,
      'entity_flags' => ENT_QUOTES | ENT_SUBSTITUTE,
      'escape' => [Html::class, 'encode'],
      'helpers' => ArrayHelper::merge($helpers, $this->helpers),
      'partials_loader' => new Loader(['viewRenderer' => $this]),
      'strict_callables' => true
    ];

    if ($this->enableCaching) {
      /** @var \yii\caching\Cache $cache */
      $cache = Instance::ensure($this->cache, \yii\caching\Cache::class);
      $this->cache = $cache;
      $options['cache'] = new Cache(['viewRenderer' => $this]);
    }

    if ($this->enableLogging) $options['logger'] = new Logger;
    $this->engine = new \Mustache_Engine($options);

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
  function render($view, $file, $params = []): string {
    /** @var \yii\caching\Cache $cache */
    $cache = $this->cache;
    $cacheKey = [__CLASS__, $file];

    if ($this->enableCaching && $cache->exists($cacheKey))
      $output = $cache->get($cacheKey);
    else {
      $path = FileHelper::localize($file);
      if (!is_file($path)) throw new InvalidCallException("View file '$file' does not exist.");

      $output = @file_get_contents($path);
      if ($this->enableCaching) $cache->set($cacheKey, $output, $this->cachingDuration);
    }

    /** @var \Mustache_Engine $engine */
    $engine = $this->engine;
    $values = ArrayHelper::merge(['this' => $view], $params);
    return $engine->render($output, $values);
  }

  /**
   * Sets the values to prepend to the context stack, so they will be available in any view loaded by this instance.
   * @param array $value The list of the values to prepend to the context stack.
   * @return $this This instance.
   */
  function setHelpers(array $value): self {
    if ($this->engine) $this->engine->setHelpers($value);
    else $this->helpers = $value;
    return $this;
  }
}

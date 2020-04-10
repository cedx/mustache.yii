<?php declare(strict_types=1);
namespace yii\mustache;

use yii\base\{View};
use yii\di\{Instance};
use yii\helpers\{ArrayHelper, Html};

/**
 * View renderer allowing to use the [Mustache](https://mustache.github.io) template syntax.
 * @property \Mustache_HelperCollection $helpers The list of the values prepended to the context stack.
 */
class ViewRenderer extends \yii\base\ViewRenderer {

  /** @var string|array<string, mixed>|\yii\caching\CacheInterface The cache object or the application component ID of the cache object. */
  public $cache = 'cache';

  /** @var int The time in seconds that the compiled views can remain valid in cache. If set to `0`, the cache never expires. */
  public int $cachingDuration = 0;

  /** @var bool Value indicating whether to enable caching view templates. */
  public bool $enableCaching = false;

  /** @var bool Value indicating whether to enable logging engine messages. */
  public bool $enableLogging = false;

  /** @var View The view object used to render views. */
  public ?View $view = null;

  /** @var \Mustache_Engine|null The underlying Mustache template engine. */
  private ?\Mustache_Engine $engine = null;

  /** @var array<string, mixed> The values prepended to the context stack. */
  private array $helpers = [];

  /**
   * Gets the values prepended to the context stack, so they will be available in any view loaded by this instance.
   * @return \Mustache_HelperCollection The list of the values prepended to the context stack.
   */
  function getHelpers(): \Mustache_HelperCollection {
    return $this->engine ? $this->engine->getHelpers() : new \Mustache_HelperCollection($this->helpers);
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
  }

  /**
   * Renders a view file.
   * @param View $view The view object used for rendering the file.
   * @param string $file The view file.
   * @param array<string, mixed> $params The parameters to be passed to the view file.
   * @return string The rendering result.
   */
  function render($view, $file, $params = []): string {
    assert($view instanceof View);
    assert(is_string($file) && mb_strlen($file) > 0);

    $this->view = $view;

    /** @var \yii\caching\Cache $cache */
    $cache = $this->cache;
    $cacheKey = [__METHOD__, $file];

    if ($this->enableCaching && $cache->exists($cacheKey)) $output = $cache->get($cacheKey);
    else {
      $output = (string) @file_get_contents($file);
      if ($this->enableCaching) $cache->set($cacheKey, $output, $this->cachingDuration);
    }

    /** @var \Mustache_Engine $engine */
    $engine = $this->engine;
    $values = ArrayHelper::merge(['this' => $this->view], $params);
    return $engine->render($output, $values);
  }

  /**
   * Sets the values to prepend to the context stack, so they will be available in any view loaded by this instance.
   * @param array<string, mixed> $value The list of the values to prepend to the context stack.
   * @return $this This instance.
   */
  function setHelpers(array $value): self {
    if ($this->engine) $this->engine->setHelpers($value);
    else $this->helpers = $value;
    return $this;
  }
}

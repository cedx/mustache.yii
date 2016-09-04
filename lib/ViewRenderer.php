<?php
/**
 * Implementation of the `yii\mustache\ViewRenderer` class.
 */
namespace yii\mustache;

use yii\base\InvalidCallException;
use yii\helpers\{ArrayHelper, FileHelper, Html};

/**
 * View renderer allowing to use the [Mustache](http://mustache.github.io) template syntax.
 */
class ViewRenderer extends \yii\base\ViewRenderer {

  /**
   * @var string The string prefixed to every cache key in order to avoid name collisions.
   */
  const CACHE_KEY_PREFIX = __CLASS__;

  /**
   * @var string The identifier of the cache application component that is used to cache the compiled views. If set to `null`, caching is disabled.
   */
  public $cacheId = null;

  /**
   * @var int The time in seconds that the compiled views can remain valid in cache. If set to `0`, the cache never expires.
   */
  public $cachingDuration = 0;

  /**
   * @var bool Value indicating whether to enable the logging of engine messages.
   */
  public $enableLogging = false;

  /**
   * @var \Mustache_Engine The underlying Mustache template engine.
   */
  private $engine;

  /**
   * @var array The values prepended to the context stack.
   */
  private $helpers = [];

  /**
   * @var bool Value indicating whether the instance is initialized.
   */
  private $isInitialized = false;

  /**
   * Gets the values prepended to the context stack, so they will be available in any view loaded by this instance.
   * @return \Mustache_HelperCollection The list of the values prepended to the context stack. Always `null` until the component is fully initialized.
   */
  public function getHelpers() {
    return $this->isInitialized ? $this->engine->getHelpers() : null;
  }

  /**
   * Initializes the application component.
   */
  public function init() {
    $helpers = [
      'app' => \Yii::$app,
      'format' => new helpers\Format(),
      'html' => new helpers\Html(),
      'i18n' => new helpers\I18N(),
      'url' => new helpers\Url(),
      'yii' => [
        'debug' => YII_DEBUG,
        'env' => YII_ENV,
        'env_dev' => YII_ENV_DEV,
        'env_prod' => YII_ENV_PROD,
        'env_test' => YII_ENV_TEST
      ]
    ];

    $options = [
      'cache' => new Cache($this),
      'charset' => \Yii::$app->charset,
      'entity_flags' => ENT_QUOTES | ENT_SUBSTITUTE,
      'escape' => [Html::class, 'encode'],
      'helpers' => ArrayHelper::merge($helpers, $this->helpers),
      'partials_loader' => new Loader($this),
      'strict_callables' => true
    ];

    if($this->enableLogging) $options['logger'] = new Logger();
    $this->engine = new \Mustache_Engine($options);
    $this->isInitialized = true;

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
    $cache = $this->cacheId ? \Yii::$app->get($this->cacheId) : null;
    $key = static::CACHE_KEY_PREFIX . $file;

    if($cache && $cache->exists($key))
      $output = $cache[$key];
    else {
      $path = FileHelper::localize($file);
      if(!is_file($path)) throw new InvalidCallException(\Yii::t('yii', 'View file "{file}" does not exist.', ['file' => $file]));

      $output = @file_get_contents($path);
      if($cache) $cache->set($key, $output, $this->cachingDuration);
    }

    $values = ArrayHelper::merge(['this' => $view], is_array($params) ? $params : []);
    return $this->engine->render($output, $values);
  }

  /**
   * Sets the values to prepend to the context stack, so they will be available in any view loaded by this instance.
   * @param array $value The list of the values to prepend to the context stack.
   */
  public function setHelpers(array $value) {
    if($this->isInitialized) $this->engine->setHelpers($value);
    else $this->helpers = $value;
  }
}

<?php declare(strict_types=1);
namespace yii\mustache;

use yii\base\{BaseObject, InvalidConfigException, View, ViewNotFoundException};
use yii\helpers\{FileHelper};

/** Loads views from the file system. */
class Loader extends BaseObject implements \Mustache_Loader {

	/** @var ViewRenderer The instance used to render the views. */
	public ?ViewRenderer $viewRenderer = null;

	/** @var string[] The loaded views. */
	private array $views = [];

	/**
	 * Initializes this object.
	 * @throws InvalidConfigException The view renderer is not initialized.
	 */
	function init(): void {
		parent::init();
		if (!$this->viewRenderer) throw new InvalidConfigException("The view renderer is not initialized.");
	}

	/**
	 * Loads the view with the specified name.
	 * @param string $name The view name.
	 * @return string The view contents.
	 * @throws ViewNotFoundException Unable to locate the view file.
	 */
	function load($name): string {
		assert(is_string($name) && mb_strlen($name) > 0);

		static $findViewFile;
		if (!isset($findViewFile)) {
			$findViewFile = (new \ReflectionClass(View::class))->getMethod("findViewFile");
			$findViewFile->setAccessible(true);
		}

		if (!isset($this->views[$name])) {
			/** @var ViewRenderer $viewRenderer */
			$viewRenderer = $this->viewRenderer;

			/** @var \yii\caching\Cache $cache */
			$cache = $viewRenderer->cache;
			$cacheKey = [__METHOD__, $name];

			if ($viewRenderer->enableCaching && $cache->exists($cacheKey)) $output = $cache->get($cacheKey);
			else {
				/** @var View $view */
				$view = $viewRenderer->view;
				$path = $findViewFile->invoke($view, $name, $view->context);
				if ($view->theme) {
					/** @var \yii\base\Theme $theme */
					$theme = $view->theme;
					$path = $theme->applyTo($path);
				}

				$fileInfo = new \SplFileInfo($path);
				if (!$fileInfo->isFile()) throw new ViewNotFoundException("The view file does not exist: {$fileInfo->getPathname()}");

				$fileObject = new \SplFileObject(FileHelper::localize($fileInfo->getPathname()));
				$output = (string) $fileObject->fread($fileObject->getSize());
				if ($viewRenderer->enableCaching) $cache->set($cacheKey, $output, $viewRenderer->cachingDuration);
			}

			$this->views[$name] = $output;
		}

		return $this->views[$name];
	}
}

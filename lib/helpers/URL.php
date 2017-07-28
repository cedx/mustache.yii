<?php
declare(strict_types=1);
namespace yii\mustache\helpers;

use yii\helpers\{Url as URLHelper};
use yii\mustache\{Helper};

/**
 * Provides a set of methods for managing URLs.
 * @property \Closure $base A function returning the base URL of the current request.
 * @property string $canonical The canonical URL of the currently requested page.
 * @property \Closure $current A function creating a URL by using the current route and the GET parameters.
 * @property \Closure $home A function returning the home URL.
 * @property \Closure $previous A function returning the URL previously remembered.
 * @property \Closure $to A function creating a URL based on the given parameters.
 * @property \Closure $toRoute A function creating a URL for the given route.
 */
class URL extends Helper {

  /**
   * Returns a function returning the base URL of the current request.
   * @return \Closure A function returning the base URL of the current request.
   */
  public function getBase(): \Closure {
    return function(string $value, \Mustache_LambdaHelper $helper): string {
      return URLHelper::base($helper->render($value) ?: false);
    };
  }

  /**
   * Returns the canonical URL of the currently requested page.
   * @return string The canonical URL of the currently requested page.
   */
  public function getCanonical(): string {
    return URLHelper::canonical();
  }

  /**
   * Returns a function creating a URL by using the current route and the GET parameters.
   * @return \Closure A function creating a URL by using the current route and the GET parameters.
   */
  public function getCurrent(): \Closure {
    return function(string $value, \Mustache_LambdaHelper $helper): string {
      $args = $this->parseArguments($helper->render($value), 'params', ['scheme' => false]);
      return URLHelper::current($args['params'], $args['scheme']);
    };
  }

  /**
   * Returns a function returning the home URL.
   * @return \Closure A function returning the home URL.
   */
  public function getHome(): \Closure {
    return function(string $value, \Mustache_LambdaHelper $helper): string {
      return URLHelper::home($helper->render($value) ?: false);
    };
  }

  /**
   * Returns a function returning the URL previously remembered.
   * @return \Closure A function returning the URL previously remembered.
   */
  public function getPrevious(): \Closure {
    return function(string $value, \Mustache_LambdaHelper $helper) {
      return URLHelper::previous($helper->render($value) ?: null);
    };
  }

  /**
   * Returns a function creating a URL based on the given parameters.
   * @return \Closure A function creating a URL based on the given parameters.
   */
  public function getTo(): \Closure {
    return function(string $value, \Mustache_LambdaHelper $helper): string {
      $args = $this->parseArguments($helper->render($value), 'url', ['scheme' => false]);
      return URLHelper::to($args['url'], $args['scheme']);
    };
  }

  /**
   * Returns a function creating a URL for the given route.
   * @return \Closure A function creating a URL for the given route.
   */
  public function getToRoute(): \Closure {
    return function(string $value, \Mustache_LambdaHelper $helper): string {
      $args = $this->parseArguments($helper->render($value), 'route', ['scheme' => false]);
      return URLHelper::toRoute($args['route'], $args['scheme']);
    };
  }
}

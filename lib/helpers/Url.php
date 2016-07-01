<?php
/**
 * Implementation of the `yii\mustache\helpers\Url` class.
 */
namespace yii\mustache\helpers;

// Module dependencies.
use yii\helpers\Url as UrlHelper;

/**
 * Provides a set of methods for managing URLs.
 */
class Url extends Helper {

  /**
   * Returns a function returning the base URL of the current request.
   * @return \Closure A function returning the base URL of the current request.
   */
  public function getBase(): \Closure {
    return function($value, \Mustache_LambdaHelper $helper) {
      return UrlHelper::base($helper->render($value) ?: false);
    };
  }

  /**
   * Returns the canonical URL of the currently requested page.
   * @return string The canonical URL of the currently requested page.
   */
  public function getCanonical(): string {
    return UrlHelper::canonical();
  }

  /**
   * Returns a function creating a URL by using the current route and the GET parameters.
   * @return \Closure A function creating a URL by using the current route and the GET parameters.
   */
  public function getCurrent(): \Closure {
    return function($value, \Mustache_LambdaHelper $helper) {
      $args = $this->parseArguments($helper->render($value), 'params', ['scheme' => false]);
      return UrlHelper::current($args['params'], $args['scheme']);
    };
  }

  /**
   * Returns a function returning the home URL.
   * @return \Closure A function returning the home URL.
   */
  public function getHome(): \Closure {
    return function($value, \Mustache_LambdaHelper $helper) {
      return UrlHelper::home($helper->render($value) ?: false);
    };
  }

  /**
   * Returns a function returning the URL previously remembered.
   * @return \Closure A function returning the URL previously remembered.
   */
  public function getPrevious(): \Closure {
    return function($value, \Mustache_LambdaHelper $helper) {
      return UrlHelper::previous($helper->render($value) ?: null);
    };
  }

  /**
   * Returns a function creating a URL based on the given parameters.
   * @return \Closure A function creating a URL based on the given parameters.
   */
  public function getTo(): \Closure {
    return function($value, \Mustache_LambdaHelper $helper) {
      $args = $this->parseArguments($helper->render($value), 'url', ['scheme' => false]);
      return UrlHelper::to($args['url'], $args['scheme']);
    };
  }

  /**
   * Returns a function creating a URL for the given route.
   * @return \Closure A function creating a URL for the given route.
   */
  public function getToRoute(): \Closure {
    return function($value, \Mustache_LambdaHelper $helper) {
      $args = $this->parseArguments($helper->render($value), 'route', ['scheme' => false]);
      return UrlHelper::toRoute($args['route'], $args['scheme']);
    };
  }
}

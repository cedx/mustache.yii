<?php
/**
 * @file
 * Implementation of the `yii\mustache\helpers\Html` class.
 */
namespace yii\mustache\helpers;

// Dependencies.
use yii\helpers\Markdown;
use yii\widgets\Spaceless;

/**
 * Provides a set of methods for generating commonly used HTML tags.
 */
class Html extends Helper {

  /**
   * Returns the tag marking the beginning of an HTML body section.
   * @return The tag marking the beginning of an HTML body section.
   */
  public function getBeginBody(): string {
    $view = \Yii::$app->view;
    if(!$view || !$view->hasMethod('beginBody')) return '';

    return $this->captureOutput(function() use($view) {
      $view->beginBody();
    });
  }

  /**
   * Returns the tag marking the ending of an HTML body section.
   * @return The tag marking the ending of an HTML body section.
   */
  public function getEndBody(): string {
    $view = \Yii::$app->view;
    if(!$view || !$view->hasMethod('endBody')) return '';

    return $this->captureOutput(function() use($view) {
      $view->endBody();
    });
  }

  /**
   * Returns the tag marking the position of an HTML head section.
   * @return The tag marking the position of an HTML head section.
   */
  public function getHead(): string {
    $view = \Yii::$app->view;
    if(!$view || !$view->hasMethod('head')) return '';

    return $this->captureOutput(function() use($view) {
      $view->head();
    });
  }

  /**
   * Returns a function converting Markdown into HTML.
   * @return A function converting Markdown into HTML.
   */
  public function getMarkdown(): \Closure {
    return function($value, \Mustache_LambdaHelper $helper) {
      $args = $this->parseArguments($helper->render($value), 'markdown', ['flavor' => Markdown::$defaultFlavor]);
      return Markdown::process($args['markdown'], $args['flavor']);
    };
  }

  /**
   * Returns a function converting Markdown into HTML but only parsing inline elements.
   * @return A function converting Markdown into HTML but only parsing inline elements.
   */
  public function getMarkdownParagraph(): \Closure {
    return function($value, \Mustache_LambdaHelper $helper) {
      $args = $this->parseArguments($helper->render($value), 'markdown', ['flavor' => Markdown::$defaultFlavor]);
      return Markdown::processParagraph($args['markdown'], $args['flavor']);
    };
  }

  /**
   * Returns a function removing whitespace characters between HTML tags.
   * @return A function removing whitespaces between HTML tags.
   */
  public function getSpaceless(): \Closure {
    return function($value, \Mustache_LambdaHelper $helper) {
      return $this->captureOutput(function() use($helper, $value) {
        Spaceless::begin();
        echo $helper->render($value);
        Spaceless::end();
      });
    };
  }

  /**
   * Returns a function setting the view title.
   * @return A function setting the view title.
   */
  public function getViewTitle(): \Closure {
    return function($value, \Mustache_LambdaHelper $helper) {
      $view = \Yii::$app->view;
      if($view && $view->canSetProperty('title')) $view->title = trim($helper->render($value));
    };
  }
}

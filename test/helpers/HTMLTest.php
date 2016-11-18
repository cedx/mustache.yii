<?php
/**
 * Implementation of the `yii\test\mustache\helpers\HTMLTest` class.
 */
namespace yii\test\mustache\helpers;

use yii\mustache\helpers\{HTML};
use yii\web\{View};

/**
 * Tests the features of the `yii\mustache\helpers\HTML` class.
 */
class HTMLTest extends \PHPUnit_Framework_TestCase {

  /**
   * @var \Mustache_LambdaHelper The engine used to render strings.
   */
  private $helper;

  /**
   * Tests the `HTML::getBeginBody()` method.
   */
  public function testGetBeginBody() {
    \Yii::$app->set('view', new View());
    $this->assertEquals(View::PH_BODY_BEGIN, (new HTML())->getBeginBody());
  }

  /**
   * Tests the `HTML::getEndBody()` method.
   */
  public function testGetEndBody() {
    \Yii::$app->set('view', new View());
    $this->assertEquals(View::PH_BODY_END, (new HTML())->getEndBody());
  }

  /**
   * Tests the `HTML::getHead()` method.
   */
  public function testHead() {
    \Yii::$app->set('view', new View());
    $this->assertEquals(View::PH_HEAD, (new HTML())->getHead());
  }

  /**
   * Tests the `HTML::getMarkdown()` method.
   */
  public function testGetMarkdown() {
    $closure = (new HTML())->getMarkdown();
    $this->assertEquals("<h1>title</h1>\n", $closure("# title", $this->helper));
  }

  /**
   * Tests the `HTML::getSpaceless()` method.
   */
  public function testGetSpaceless() {
    $closure = (new HTML())->getSpaceless();
    $this->assertEquals('<strong>label</strong><em>label</em>', $closure("<strong>label</strong>  \r\n  <em>label</em>", $this->helper));
    $this->assertEquals('<strong> label </strong><em> label </em>', $closure('<strong> label </strong>  <em> label </em>', $this->helper));
  }

  /**
   * Tests the `HTML::getViewTitle()` method.
   */
  public function testViewTitle() {
    \Yii::$app->set('view', new View());
    $this->assertNull(\Yii::$app->view->title);

    $closure = (new HTML())->getViewTitle();
    $closure('Foo Bar', $this->helper);
    $this->assertEquals('Foo Bar', \Yii::$app->view->title);
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp() {
    $this->helper = new \Mustache_LambdaHelper(new \Mustache_Engine(), new \Mustache_Context());
  }
}

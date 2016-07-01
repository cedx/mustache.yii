<?php
/**
 * Implementation of the `yii\test\mustache\HtmlTest` class.
 */
namespace yii\test\mustache\helpers;

// Module dependencies.
use yii\mustache\helpers\Html;
use yii\web\View;

/**
 * Tests the features of the `yii\mustache\helpers\Html` class.
 */
class HtmlTest extends \PHPUnit_Framework_TestCase {

  /**
   * @var Mustache_LambdaHelper $helper
   * The engine used to render strings.
   */
  private $helper;

  /**
   * Tests the `getBeginBody` method.
   */
  public function testGetBeginBody() {
    \Yii::$app->set('view', new View());
    $this->assertEquals(View::PH_BODY_BEGIN, (new Html())->getBeginBody());
  }

  /**
   * Tests the `getEndBody` method.
   */
  public function testGetEndBody() {
    \Yii::$app->set('view', new View());
    $this->assertEquals(View::PH_BODY_END, (new Html())->getEndBody());
  }

  /**
   * Tests the `getHead` method.
   */
  public function testHead() {
    \Yii::$app->set('view', new View());
    $this->assertEquals(View::PH_HEAD, (new Html())->getHead());
  }

  /**
   * Tests the `getMarkdown` method.
   */
  public function testGetMarkdown() {
    $closure = (new Html())->getMarkdown();
    $this->assertEquals("<h1>title</h1>\n", $closure("# title", $this->helper));
  }

  /**
   * Tests the `getSpaceless` method.
   */
  public function testGetSpaceless() {
    $closure = (new Html())->getSpaceless();
    $this->assertEquals('<strong>label</strong><em>label</em>', $closure("<strong>label</strong>  \r\n  <em>label</em>", $this->helper));
    $this->assertEquals('<strong> label </strong><em> label </em>', $closure('<strong> label </strong>  <em> label </em>', $this->helper));
  }

  /**
   * Tests the `getViewTitle` method.
   */
  public function testViewTitle() {
    \Yii::$app->set('view', new View());
    $this->assertNull(\Yii::$app->view->title);

    $closure = (new Html())->getViewTitle();
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

<?php
namespace yii\mustache\helpers;

use PHPUnit\Framework\{TestCase};
use yii\web\{View};

/**
 * Tests the features of the `yii\mustache\helpers\HTML` class.
 */
class HTMLTest extends TestCase {

  /**
   * @var \Mustache_LambdaHelper The engine used to render strings.
   */
  private $helper;

  /**
   * @test HTML::getBeginBody
   */
  public function testGetBeginBody() {
    \Yii::$app->set('view', \Yii::createObject(View::class));
    $this->assertEquals(View::PH_BODY_BEGIN, (new HTML())->getBeginBody());
  }

  /**
   * @test HTML::getEndBody
   */
  public function testGetEndBody() {
    \Yii::$app->set('view', \Yii::createObject(View::class));
    $this->assertEquals(View::PH_BODY_END, (new HTML())->getEndBody());
  }

  /**
   * @test HTML::getHead
   */
  public function testHead() {
    \Yii::$app->set('view', \Yii::createObject(View::class));
    $this->assertEquals(View::PH_HEAD, (new HTML())->getHead());
  }

  /**
   * @test HTML::getMarkdown
   */
  public function testGetMarkdown() {
    $closure = (new HTML())->getMarkdown();
    $this->assertEquals("<h1>title</h1>\n", $closure("# title", $this->helper));
  }

  /**
   * @test HTML::getSpaceless
   */
  public function testGetSpaceless() {
    $closure = (new HTML())->getSpaceless();
    $this->assertEquals('<strong>label</strong><em>label</em>', $closure("<strong>label</strong>  \r\n  <em>label</em>", $this->helper));
    $this->assertEquals('<strong> label </strong><em> label </em>', $closure('<strong> label </strong>  <em> label </em>', $this->helper));
  }

  /**
   * @test HTML::getViewTitle
   */
  public function testViewTitle() {
    \Yii::$app->set('view', \Yii::createObject(View::class));
    $this->assertNull(\Yii::$app->view->title);

    $closure = (new HTML())->getViewTitle();
    $closure('Foo Bar', $this->helper);
    $this->assertEquals('Foo Bar', \Yii::$app->view->title);
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp() {
    $this->helper = \Yii::createObject(
      \Mustache_LambdaHelper::class,
      [\Yii::createObject(\Mustache_Engine::class), \Yii::createObject(\Mustache_Context::class)]
    );
  }
}

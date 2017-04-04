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
    it('', function() {

    });

    \Yii::$app->set('view', new View());
    $this->assertEquals(View::PH_BODY_BEGIN, (new HTML())->beginBody);
  }

  /**
   * @test HTML::getEndBody
   */
  public function testGetEndBody() {
    it('', function() {

    });

    \Yii::$app->set('view', new View());
    $this->assertEquals(View::PH_BODY_END, (new HTML())->endBody);
  }

  /**
   * @test HTML::getHead
   */
  public function testHead() {
    it('', function() {

    });

    \Yii::$app->set('view', new View());
    $this->assertEquals(View::PH_HEAD, (new HTML())->head);
  }

  /**
   * @test HTML::getMarkdown
   */
  public function testGetMarkdown() {
    it('', function() {

    });

    $closure = (new HTML())->markdown;
    $this->assertEquals("<h1>title</h1>\n", $closure("# title", $this->helper));
  }

  /**
   * @test HTML::getSpaceless
   */
  public function testGetSpaceless() {
    it('', function() {

    });

    $closure = (new HTML())->spaceless;
    $this->assertEquals('<strong>label</strong><em>label</em>', $closure("<strong>label</strong>  \r\n  <em>label</em>", $this->helper));
    $this->assertEquals('<strong> label </strong><em> label </em>', $closure('<strong> label </strong>  <em> label </em>', $this->helper));
  }

  /**
   * @test HTML::getViewTitle
   */
  public function testViewTitle() {
    it('', function() {

    });

    \Yii::$app->set('view', new View());
    $this->assertNull(\Yii::$app->view->title);

    $closure = (new HTML())->viewTitle;
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

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
    it('should return the tag marking the beginning of an HTML body section', function() {
      \Yii::$app->set('view', View::class);
      expect((new HTML())->beginBody)->to->equal(View::PH_BODY_BEGIN);
    });
  }

  /**
   * @test HTML::getEndBody
   */
  public function testGetEndBody() {
    it('should return the tag marking the ending of an HTML body section', function() {
      \Yii::$app->set('view', View::class);
      expect((new HTML())->endBody)->to->equal(View::PH_BODY_END);
    });
  }

  /**
   * @test HTML::getHead
   */
  public function testHead() {
    it('should return the tag marking the position of an HTML head section', function() {
      \Yii::$app->set('view', View::class);
      expect((new HTML())->head)->to->equal(View::PH_HEAD);
    });
  }

  /**
   * @test HTML::getMarkdown
   */
  public function testGetMarkdown() {
    it('should convert Markdown code to HTML', function() {
      $closure = (new HTML())->markdown;
      expect($closure("# title", $this->helper))->to->equal("<h1>title</h1>\n");
    });
  }

  /**
   * @test HTML::getSpaceless
   */
  public function testGetSpaceless() {
    it('should remove whitespace characters between HTML tags', function() {
      $closure = (new HTML())->spaceless;
      expect($closure("<strong>label</strong>  \r\n  <em>label</em>", $this->helper))->to->equal('<strong>label</strong><em>label</em>');
      expect($closure('<strong> label </strong>  <em> label </em>', $this->helper))->to->equal('<strong> label </strong><em> label </em>');
    });
  }

  /**
   * @test HTML::getViewTitle
   */
  public function testViewTitle() {
    it('should set the view title', function() {
      \Yii::$app->set('view', View::class);
      expect(\Yii::$app->view->title)->to->be->null;

      $closure = (new HTML())->viewTitle;
      $closure('Foo Bar', $this->helper);
      expect(\Yii::$app->view->title)->to->equal('Foo Bar');
    });
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp() {
    $this->helper = new \Mustache_LambdaHelper(new \Mustache_Engine(), new \Mustache_Context());
  }
}

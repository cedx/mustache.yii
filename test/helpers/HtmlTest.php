<?php
declare(strict_types=1);
namespace yii\mustache\helpers;

use function PHPUnit\Expect\{expect, it};
use PHPUnit\Framework\{TestCase};
use yii\web\{View};

/**
 * Tests the features of the `yii\mustache\helpers\Html` class.
 */
class HtmlTest extends TestCase {

  /**
   * @var \Mustache_LambdaHelper The engine used to render strings.
   */
  private $helper;

  /**
   * Performs a common set of tasks just before the first test of the class is run.
   */
  public static function setUpBeforeClass(): void {
    \Yii::$app->set('view', View::class);
  }

  /**
   * @test Html::getBeginBody
   */
  public function testGetBeginBody(): void {
    it('should return the tag marking the beginning of an HTML body section', function() {
      expect((new Html)->beginBody)->to->equal(View::PH_BODY_BEGIN);
    });
  }

  /**
   * @test Html::getEndBody
   */
  public function testGetEndBody(): void {
    it('should return the tag marking the ending of an HTML body section', function() {
      expect((new Html)->endBody)->to->equal(View::PH_BODY_END);
    });
  }

  /**
   * @test Html::getHead
   */
  public function testHead(): void {
    it('should return the tag marking the position of an HTML head section', function() {
      expect((new Html)->head)->to->equal(View::PH_HEAD);
    });
  }

  /**
   * @test Html::getMarkdown
   */
  public function testGetMarkdown(): void {
    it('should convert Markdown code to HTML', function() {
      $closure = (new Html)->markdown;
      expect($closure("# title", $this->helper))->to->equal("<h1>title</h1>\n");
    });
  }

  /**
   * @test Html::getMarkdownParagraph
   */
  public function testGetMarkdownParagraph(): void {
    it('should convert Markdown code to HTML', function() {
      $closure = (new Html)->markdownParagraph;
      expect($closure("*title*", $this->helper))->to->equal('<em>title</em>');
    });
  }

  /**
   * @test Html::getSpaceless
   */
  public function testGetSpaceless(): void {
    it('should remove whitespace characters between HTML tags', function() {
      $closure = (new Html)->spaceless;
      expect($closure("<strong>label</strong>  \r\n  <em>label</em>", $this->helper))->to->equal('<strong>label</strong><em>label</em>');
      expect($closure('<strong> label </strong>  <em> label </em>', $this->helper))->to->equal('<strong> label </strong><em> label </em>');
    });
  }

  /**
   * @test Html::getViewTitle
   */
  public function testViewTitle(): void {
    it('should set the view title', function() {
      expect(\Yii::$app->view->title)->to->be->null;

      $closure = (new Html)->viewTitle;
      $closure('Foo Bar', $this->helper);
      expect(\Yii::$app->view->title)->to->equal('Foo Bar');
    });
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp(): void {
    $this->helper = new \Mustache_LambdaHelper(new \Mustache_Engine, new \Mustache_Context);
  }
}

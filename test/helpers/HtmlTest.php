<?php declare(strict_types=1);
namespace yii\mustache\helpers;

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
   * This method is called before the first test of this test class is run.
   * @beforeClass
   */
  static function setUpBeforeClass(): void {
    \Yii::$app->set('view', View::class);
  }

  /**
   * Tests the `Html::getBeginBody()` method.
   * @test
   */
  function testGetBeginBody(): void {
    // It should return the tag marking the beginning of an HTML body section.
    assertThat((new Html)->beginBody, equalTo(View::PH_BODY_BEGIN));
  }

  /**
   * Tests the `Html::getEndBody()` method.
   * @test
   */
  function testGetEndBody(): void {
    // It should return the tag marking the ending of an HTML body section.
    assertThat((new Html)->endBody, equalTo(View::PH_BODY_END));
  }

  /**
   * Tests the `Html::getHead()` method.
   * @test
   */
  function testHead(): void {
    // It should return the tag marking the position of an HTML head section.
    assertThat((new Html)->head, equalTo(View::PH_HEAD));
  }

  /**
   * Tests the `Html::getMarkdown()` method.
   * @test
   */
  function testGetMarkdown(): void {
    // It should convert Markdown code to HTML.
    $closure = (new Html)->markdown;
    assertThat($closure("# title", $this->helper), equalTo("<h1>title</h1>\n"));
  }

  /**
   * Tests the `Html::getMarkdownParagraph()` method.
   * @test
   */
  function testGetMarkdownParagraph(): void {
    // It should convert Markdown code to HTML.
    $closure = (new Html)->markdownParagraph;
    assertThat($closure("*title*", $this->helper), equalTo('<em>title</em>'));
  }

  /**
   * Tests the `Html::getSpaceless()` method.
   * @test
   */
  function testGetSpaceless(): void {
    // It should remove whitespace characters between HTML tags.
    $closure = (new Html)->spaceless;
    assertThat($closure("<strong>label</strong>  \r\n  <em>label</em>", $this->helper), equalTo('<strong>label</strong><em>label</em>'));
    assertThat($closure('<strong> label </strong>  <em> label </em>', $this->helper), equalTo('<strong> label </strong><em> label </em>'));
  }

  /**
   * Tests the `Html::getViewTitle()` method.
   * @test
   */
  function testViewTitle(): void {
    // It should set the view title.
    assertThat(\Yii::$app->view->title, isNull());

    $closure = (new Html)->viewTitle;
    $closure('Foo Bar', $this->helper);
    assertThat(\Yii::$app->view->title, equalTo('Foo Bar'));
  }

  /**
   * This method is called before each test.
   * @before
   */
  protected function setUp(): void {
    $this->helper = new \Mustache_LambdaHelper(new \Mustache_Engine, new \Mustache_Context);
  }
}

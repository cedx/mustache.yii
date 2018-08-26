<?php
declare(strict_types=1);
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
   * Performs a common set of tasks just before the first test of the class is run.
   */
  static function setUpBeforeClass(): void {
    \Yii::$app->set('view', View::class));
  }

  /**
   * Tests the `Html::getBeginBody
   */
  function testGetBeginBody(): void {
    // It should return the tag marking the beginning of an HTML body section.
      assertThat((new Html)->beginBody, equalTo(View::PH_BODY_BEGIN);
    });
  }

  /**
   * Tests the `Html::getEndBody
   */
  function testGetEndBody(): void {
    // It should return the tag marking the ending of an HTML body section.
      assertThat((new Html)->endBody, equalTo(View::PH_BODY_END);
    });
  }

  /**
   * Tests the `Html::getHead
   */
  function testHead(): void {
    // It should return the tag marking the position of an HTML head section.
      assertThat((new Html)->head, equalTo(View::PH_HEAD);
    });
  }

  /**
   * Tests the `Html::getMarkdown
   */
  function testGetMarkdown(): void {
    // It should convert Markdown code to HTML.
      $closure = (new Html)->markdown;
      assertThat($closure("# title", $this->helper), equalTo("<h1>title</h1>\n");
    });
  }

  /**
   * Tests the `Html::getMarkdownParagraph
   */
  function testGetMarkdownParagraph(): void {
    // It should convert Markdown code to HTML.
      $closure = (new Html)->markdownParagraph;
      assertThat($closure("*title*", $this->helper), equalTo('<em>title</em>');
    });
  }

  /**
   * Tests the `Html::getSpaceless
   */
  function testGetSpaceless(): void {
    // It should remove whitespace characters between HTML tags.
      $closure = (new Html)->spaceless;
      assertThat($closure("<strong>label</strong>  \r\n  <em>label</em>", $this->helper), equalTo('<strong>label</strong><em>label</em>');
      assertThat($closure('<strong> label </strong>  <em> label </em>', $this->helper), equalTo('<strong> label </strong><em> label </em>');
    });
  }

  /**
   * Tests the `Html::getViewTitle
   */
  function testViewTitle(): void {
    // It should set the view title.
      assertThat(\Yii::$app->view->title, isNull());

      $closure = (new Html)->viewTitle;
      $closure('Foo Bar', $this->helper);
      assertThat(\Yii::$app->view->title, equalTo('Foo Bar');
    });
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp(): void {
    $this->helper = new \Mustache_LambdaHelper(new \Mustache_Engine, new \Mustache_Context);
  }
}

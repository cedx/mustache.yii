<?php declare(strict_types=1);
namespace yii\mustache\helpers;

use PHPUnit\Framework\{TestCase};
use yii\web\{View};
use function PHPUnit\Framework\{assertThat, equalTo, isNull};

/** @testdox yii\mustache\helpers\Html */
class HtmlTest extends TestCase {

	/** @var \Mustache_LambdaHelper The engine used to render strings. */
	private \Mustache_LambdaHelper $helper;

	/** @beforeClass This method is called before the first test of this test class is run. */
	static function setUpBeforeClass(): void {
		\Yii::$app->set("view", View::class);
	}

	/** @testdox ->getBeginBody() */
	function testGetBeginBody(): void {
		// It should return the tag marking the beginning of an HTML body section.
		assertThat((new Html)->getBeginBody(), equalTo(View::PH_BODY_BEGIN));
	}

	/** @testdox ->getEndBody() */
	function testGetEndBody(): void {
		// It should return the tag marking the ending of an HTML body section.
		assertThat((new Html)->getEndBody(), equalTo(View::PH_BODY_END));
	}

	/** @testdox ->getHead() */
	function testHead(): void {
		// It should return the tag marking the position of an HTML head section.
		assertThat((new Html)->getHead(), equalTo(View::PH_HEAD));
	}

	/** @testdox ->getMarkdown() */
	function testGetMarkdown(): void {
		// It should convert Markdown code to HTML.
		$closure = (new Html)->getMarkdown();
		assertThat($closure("# title", $this->helper), equalTo("<h1>title</h1>\n"));
	}

	/** @testdox ->getMarkdownParagraph() */
	function testGetMarkdownParagraph(): void {
		// It should convert Markdown code to HTML.
		$closure = (new Html)->getMarkdownParagraph();
		assertThat($closure("*title*", $this->helper), equalTo("<em>title</em>"));
	}

	/** @testdox ->getSpaceless() */
	function testGetSpaceless(): void {
		// It should remove whitespace characters between HTML tags.
		$closure = (new Html)->getSpaceless();
		assertThat($closure("<strong>label</strong>  \r\n  <em>label</em>", $this->helper), equalTo("<strong>label</strong><em>label</em>"));
		assertThat($closure("<strong> label </strong>  <em> label </em>", $this->helper), equalTo("<strong> label </strong><em> label </em>"));
	}

	/** @testdox ->getViewTitle() */
	function testViewTitle(): void {
		/** @var View $view */
		$view = \Yii::$app->getView();

		// It should set the view title.
		assertThat($view->title, isNull());

		$closure = (new Html)->getViewTitle();
		$closure("Foo Bar", $this->helper);
		assertThat($view->title, equalTo("Foo Bar"));
	}

	/** @before This method is called before each test. */
	protected function setUp(): void {
		$this->helper = new \Mustache_LambdaHelper(new \Mustache_Engine, new \Mustache_Context);
	}
}

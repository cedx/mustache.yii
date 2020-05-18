<?php declare(strict_types=1);
namespace yii\mustache;

use PHPUnit\Framework\{TestCase};
use yii\web\{View};
use function PHPUnit\Framework\{assertThat, equalTo, isInstanceOf, isTrue};

/** @testdox yii\mustache\ViewRenderer */
class ViewRendererTest extends TestCase {

	/** @var ViewRenderer The data context of the tests. */
	private ViewRenderer $model;

	/** @testdox ->getHelpers() */
	function testGetHelpers(): void {
		// It should return a Mustache helper collection.
		assertThat($this->model->getHelpers(), isInstanceOf(\Mustache_HelperCollection::class));
	}

	/** @testdox ->render() */
	function testRender(): void {
		$file = __DIR__."/fixtures/data.mustache";

		// It should remove placeholders when there is no corresponding binding.
		$data = [];
		[$line1, $line2, $line3, $line4] = preg_split('/\r?\n/', $this->model->render(new View, $file, $data)) ?: [];
		assertThat($line1, equalTo("<test></test>"));
		assertThat($line2, equalTo("<test></test>"));
		assertThat($line3, equalTo("<test></test>"));
		assertThat($line4, equalTo("<test>hidden</test>"));

		// It should replace placeholders with the proper values when there is a corresponding binding.
		$data = ["label" => '"Mustache"', "show" => true];
		[$line1, $line2, $line3, $line4] = preg_split('/\r?\n/', $this->model->render(new View, $file, $data)) ?: [];
		assertThat($line1, equalTo("<test>&quot;Mustache&quot;</test>"));
		assertThat($line2, equalTo('<test>"Mustache"</test>'));
		assertThat($line3, equalTo("<test>visible</test>"));
		assertThat($line4, equalTo("<test></test>"));
	}

	/** @testdox ->setHelpers() */
	function testSetHelpers(): void {
		// It should allow arrays as input.
		$this->model->setHelpers(["var" => "value"]);
		$helpers = $this->model->getHelpers();
		assertThat($helpers->has("var"), isTrue());
		assertThat($helpers->get("var"), equalTo("value"));
	}

	/** @before This method is called before each test. */
	protected function setUp(): void {
		$this->model = new ViewRenderer;
	}
}

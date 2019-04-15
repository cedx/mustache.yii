<?php declare(strict_types=1);
namespace yii\mustache;

use PHPUnit\Framework\{TestCase};
use yii\web\{View};

/** Tests the features of the `yii\mustache\ViewRenderer` class. */
class ViewRendererTest extends TestCase {

  /** @var ViewRenderer The data context of the tests. */
  private $model;

  /** @test Tests the `ViewRenderer::getHelpers()` method. */
  function testGetHelpers(): void {
    // It should return a Mustache helper collection.
    assertThat($this->model->helpers, isInstanceOf(\Mustache_HelperCollection::class));
  }

  /** @test Tests the `ViewRenderer::render()` method. */
  function testRender(): void {
    $file = __DIR__.'/fixtures/data.mustache';
    $view = new View;

    // It should remove placeholders when there is no corresponding binding.
    $data = [];
    $output = preg_split('/\r?\n/', $this->model->render($view, $file, $data));
    assertThat($output[0], equalTo('<test></test>'));
    assertThat($output[1], equalTo('<test></test>'));
    assertThat($output[2], equalTo('<test></test>'));
    assertThat($output[3], equalTo('<test>hidden</test>'));

    // It should replace placeholders with the proper values when there is a corresponding binding.
    $data = ['label' => '"Mustache"', 'show' => true];
    $output = preg_split('/\r?\n/', $this->model->render($view, $file, $data));
    assertThat($output[0], equalTo('<test>&quot;Mustache&quot;</test>'));
    assertThat($output[1], equalTo('<test>"Mustache"</test>'));
    assertThat($output[2], equalTo('<test>visible</test>'));
    assertThat($output[3], equalTo('<test></test>'));
  }

  /** @test Tests the `ViewRenderer::setHelpers()` method. */
  function testSetHelpers(): void {
    // It should allow arrays as input.
    $this->model->setHelpers(['var' => 'value']);
    $helpers = $this->model->helpers;
    assertThat($helpers->has('var'), isTrue());
    assertThat($helpers->get('var'), equalTo('value'));
  }

  /** @before This method is called before each test. */
  protected function setUp(): void {
    $this->model = new ViewRenderer;
  }
}

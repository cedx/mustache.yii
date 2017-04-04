<?php
namespace yii\mustache;

use PHPUnit\Framework\{TestCase};
use yii\web\{View};

/**
 * Tests the features of the `yii\mustache\ViewRenderer` class.
 */
class ViewRendererTest extends TestCase {

  /**
   * @var ViewRenderer The data context of the tests.
   */
  private $model;

  /**
   * @test ViewRenderer::getHelpers
   */
  public function testGetHelpers() {
    $this->assertInstanceOf(\Mustache_HelperCollection::class, $this->model->helpers);
  }

  /**
   * @test ViewRenderer::render
   */
  public function testRender() {
    $file = __DIR__.'/fixtures/data.mustache';

    $data = null;
    $output = preg_split('/\r?\n/', $this->model->render(new View(), $file, $data));
    $this->assertEquals('<test></test>', $output[0]);
    $this->assertEquals('<test></test>', $output[1]);
    $this->assertEquals('<test></test>', $output[2]);
    $this->assertEquals('<test>hidden</test>', $output[3]);

    $data = ['label' => '"Mustache"', 'show' => true];
    $output = preg_split('/\r?\n/', $this->model->render(new View(), $file, $data));
    $this->assertEquals('<test>&quot;Mustache&quot;</test>', $output[0]);
    $this->assertEquals('<test>"Mustache"</test>', $output[1]);
    $this->assertEquals('<test>visible</test>', $output[2]);
    $this->assertEquals('<test></test>', $output[3]);
  }

  /**
   * @test ViewRenderer::setHelpers
   */
  public function testSetHelpers() {
    $this->model->helpers = ['var' => 'value'];

    $helpers = $this->model->helpers;
    $this->assertTrue($helpers->has('var'));
    $this->assertEquals('value', $helpers->get('var'));
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp() {
    $this->model = new ViewRenderer();
  }
}

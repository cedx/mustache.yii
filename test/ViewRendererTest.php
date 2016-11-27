<?php
/**
 * Implementation of the `yii\test\mustache\ViewRendererTest` class.
 */
namespace yii\test\mustache;

use yii\mustache\{ViewRenderer};
use yii\web\{View};

/**
 * Tests the features of the `yii\mustache\ViewRenderer` class.
 */
class ViewRendererTest extends \PHPUnit_Framework_TestCase {

  /**
   * @var ViewRenderer The data context of the tests.
   */
  private $model;

  /**
   * Tests the `ViewRenderer::getHelpers()` method.
   */
  public function testGetHelpers() {
    $helpers = $this->model->getHelpers();
    $this->assertInstanceOf(\Mustache_HelperCollection::class, $helpers);
  }

  /**
   * Tests the `ViewRenderer::render()` method.
   */
  public function testRender() {
    $file = __DIR__.'/data.mustache';

    $data = null;
    $output = preg_split('/\r?\n/', $this->model->render(\Yii::createObject(View::class), $file, $data));
    $this->assertEquals('<test></test>', $output[0]);
    $this->assertEquals('<test></test>', $output[1]);
    $this->assertEquals('<test></test>', $output[2]);
    $this->assertEquals('<test>hidden</test>', $output[3]);

    $data = ['label' => '"Mustache"', 'show' => true];
    $output = preg_split('/\r?\n/', $this->model->render(\Yii::createObject(View::class), $file, $data));
    $this->assertEquals('<test>&quot;Mustache&quot;</test>', $output[0]);
    $this->assertEquals('<test>"Mustache"</test>', $output[1]);
    $this->assertEquals('<test>visible</test>', $output[2]);
    $this->assertEquals('<test></test>', $output[3]);
  }

  /**
   * Tests the `ViewRenderer::setHelpers()` method.
   */
  public function testSetHelpers() {
    $this->model->setHelpers(['var' => 'value']);

    $helpers = $this->model->getHelpers();
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

<?php
declare(strict_types=1);
namespace yii\mustache;

use function PHPUnit\Expect\{expect, it};
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
  public function testGetHelpers(): void {
    it('should return a Mustache helper collection', function() {
      expect($this->model->helpers)->to->be->instanceOf(\Mustache_HelperCollection::class);
    });
  }

  /**
   * @test ViewRenderer::render
   */
  public function testRender(): void {
    /** @var View $view */
    $view = \Yii::createObject(View::class);
    $file = __DIR__.'/fixtures/data.mustache';

    it('should remove placeholders when there is no corresponding binding', function() use ($file, $view) {
      $data = null;
      $output = preg_split('/\r?\n/', $this->model->render($view, $file, $data));
      expect($output[0])->to->equal('<test></test>');
      expect($output[1])->to->equal('<test></test>');
      expect($output[2])->to->equal('<test></test>');
      expect($output[3])->to->equal('<test>hidden</test>');
    });

    it('should replace placeholders with the proper values when there is a corresponding binding', function() use ($file, $view) {
      $data = ['label' => '"Mustache"', 'show' => true];
      $output = preg_split('/\r?\n/', $this->model->render($view, $file, $data));
      expect($output[0])->to->equal('<test>&quot;Mustache&quot;</test>');
      expect($output[1])->to->equal('<test>"Mustache"</test>');
      expect($output[2])->to->equal('<test>visible</test>');
      expect($output[3])->to->equal('<test></test>');
    });
  }

  /**
   * @test ViewRenderer::setHelpers
   */
  public function testSetHelpers(): void {
    it('should allow arrays as input', function() {
      $this->model->helpers = ['var' => 'value'];

      $helpers = $this->model->helpers;
      expect($helpers->has('var'))->to->be->true;
      expect($helpers->get('var'))->to->equal('value');
    });
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp(): void {
    $this->model = new ViewRenderer;
  }
}

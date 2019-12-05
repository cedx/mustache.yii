<?php declare(strict_types=1);
namespace yii\mustache;

use function PHPUnit\Expect\{expect, it};
use PHPUnit\Framework\{TestCase};
use yii\web\{View};

/** @testdox yii\mustache\ViewRenderer */
class ViewRendererTest extends TestCase {

  /** @var ViewRenderer The data context of the tests. */
  private ViewRenderer $model;

  /** @testdox ->getHelpers() */
  function testGetHelpers(): void {
    it('should return a Mustache helper collection', function() {
      expect($this->model->helpers)->to->be->an->instanceOf(\Mustache_HelperCollection::class);
    });
  }

  /** @testdox ->render() */
  function testRender(): void {
    $file = __DIR__.'/fixtures/data.mustache';

    it('should remove placeholders when there is no corresponding binding', function() use ($file) {
      $data = [];
      $output = preg_split('/\r?\n/', $this->model->render(new View, $file, $data)) ?: [];
      expect($output[0])->to->equal('<test></test>');
      expect($output[1])->to->equal('<test></test>');
      expect($output[2])->to->equal('<test></test>');
      expect($output[3])->to->equal('<test>hidden</test>');
    });

    it('should replace placeholders with the proper values when there is a corresponding binding', function() use ($file) {
      $data = ['label' => '"Mustache"', 'show' => true];
      $output = preg_split('/\r?\n/', $this->model->render(new View, $file, $data)) ?: [];
      expect($output[0])->to->equal('<test>&quot;Mustache&quot;</test>');
      expect($output[1])->to->equal('<test>"Mustache"</test>');
      expect($output[2])->to->equal('<test>visible</test>');
      expect($output[3])->to->equal('<test></test>');
    });
  }

  /** @testdox ->setHelpers() */
  function testSetHelpers(): void {
    it('should allow arrays as input', function() {
      $this->model->setHelpers(['var' => 'value']);
      $helpers = $this->model->helpers;
      expect($helpers->has('var'))->to->be->true;
      expect($helpers->get('var'))->to->equal('value');
    });
  }

  /** @before This method is called before each test. */
  protected function setUp(): void {
    $this->model = new ViewRenderer;
  }
}

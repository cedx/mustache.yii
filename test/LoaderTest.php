<?php
declare(strict_types=1);
namespace yii\mustache;

use function PHPUnit\Expect\{expect, it};
use PHPUnit\Framework\{TestCase};
use yii\base\{InvalidCallException};

/**
 * Tests the features of the `yii\mustache\Loader` class.
 */
class LoaderTest extends TestCase {

  /**
   * @var Loader The data context of the tests.
   */
  private $model;

  /**
   * @test Loader::findViewFile
   */
  public function testFindViewFile(): void {
    $findViewFile = function($name) {
      return $this->findViewFile($name);
    };

    it('should return the path of the corresponding view file', function() use ($findViewFile) {
      expect($findViewFile->call($this->model, '//view'))->to->equal(str_replace('/', DIRECTORY_SEPARATOR, \Yii::$app->viewPath.'/view.php'));
    });

    it('should throw an exception if the view file is not found', function() use ($findViewFile) {
      expect(function() use ($findViewFile) { $findViewFile->call($this->model, '/view'); })->to->throw(InvalidCallException::class);
    });
  }

  /**
   * @test Loader::load
   */
  public function testLoad(): void {
    it('should throw an exception if the view file is not found', function() {
      expect(function() { $this->model->load('view'); })->to->throw(InvalidCallException::class);
    });
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp(): void {
    $this->model = new Loader([
      'viewRenderer' => \Yii::createObject(ViewRenderer::class)
    ]);
  }
}

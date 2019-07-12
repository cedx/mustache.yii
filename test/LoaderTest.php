<?php declare(strict_types=1);
namespace yii\mustache;

use function PHPUnit\Expect\{expect, it};
use PHPUnit\Framework\{TestCase};
use yii\base\{InvalidCallException};

/** Tests the features of the `yii\mustache\Loader` class. */
class LoaderTest extends TestCase {

  /** @var Loader The data context of the tests. */
  private $model;

  /** @test Loader->findViewFile() */
  function testFindViewFile(): void {
    $method = (new \ReflectionClass(Loader::class))->getMethod('findViewFile');
    $method->setAccessible(true);

    it('should return the path of the corresponding view file', function() use ($method) {
      expect($method->invoke($this->model, '//view'))->to->equal(str_replace('/', DIRECTORY_SEPARATOR, \Yii::$app->viewPath.'/view.php'));
    });

    it('should throw an exception if the view file is not found', function() use ($method) {
      expect(function() use ($method) { $method->invoke($this->model, '/view'); })->to->throw(InvalidCallException::class);
    });
  }

  /** @test Loader->load() */
  function testLoad(): void {
    it('should throw an exception if the view file is not found', function() {
      expect(function() {$this->model->load('view');  })->to->throw(InvalidCallException::class);
    });
  }

  /** @before This method is called before each test. */
  protected function setUp(): void {
    $this->model = new Loader(['viewRenderer' => new ViewRenderer]);
  }
}

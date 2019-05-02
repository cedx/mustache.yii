<?php declare(strict_types=1);
namespace yii\mustache;

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

    // It should return the path of the corresponding view file.
    assertThat($method->invoke($this->model, '//view'), equalTo(str_replace('/', DIRECTORY_SEPARATOR, \Yii::$app->viewPath.'/view.php')));

    // It should throw an exception if the view file is not found.
    $this->expectException(InvalidCallException::class);
    $method->invoke($this->model, '/view');
  }

  /** @test Loader->load() */
  function testLoad(): void {
    // It should throw an exception if the view file is not found.
    $this->expectException(InvalidCallException::class);
    $this->model->load('view');
  }

  /** @before This method is called before each test. */
  protected function setUp(): void {
    $this->model = new Loader(['viewRenderer' => new ViewRenderer]);
  }
}

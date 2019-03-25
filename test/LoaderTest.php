<?php declare(strict_types=1);
namespace yii\mustache;

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
   * Tests the `Loader::findViewFile()` method.
   * @test
   */
  function testFindViewFile(): void {
    $method = (new \ReflectionClass(Loader::class))->getMethod('findViewFile');
    $method->setAccessible(true);

    // It should return the path of the corresponding view file.
    assertThat($method->invoke($this->model, '//view'), equalTo(str_replace('/', DIRECTORY_SEPARATOR, \Yii::$app->viewPath.'/view.php')));

    // It should throw an exception if the view file is not found.
    $this->expectException(InvalidCallException::class);
    $method->invoke($this->model, '/view');
  }

  /**
   * Tests the `Loader::load()` method.
   * @test
   */
  function testLoad(): void {
    // It should throw an exception if the view file is not found.
    $this->expectException(InvalidCallException::class);
    $this->model->load('view');
  }

  /**
   * This method is called before each test.
   * @before
   */
  protected function setUp(): void {
    $this->model = new Loader(['viewRenderer' => new ViewRenderer]);
  }
}

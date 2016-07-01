<?php
/**
 * Implementation of the `yii\test\mustache\LoaderTest` class.
 */
namespace yii\test\mustache;

// Module dependencies.
use yii\base\InvalidCallException;
use yii\mustache\{Loader, ViewRenderer};

/**
 * Publicly exposes the features of the `yii\mustache\Loader class.
 */
class LoaderStub extends Loader {

  /**
   * Finds the view file based on the given view name.
   * @param $name The view name.
   * @return The view file path.
   */
  public function findViewFile(string $name): string {
    return parent::findViewFile($name);
  }
}

/**
 * Tests the features of the `yii\mustache\Loader` class.
 */
class LoaderTest extends \PHPUnit_Framework_TestCase {

  /**
   * @var yii\test::mustache::LoaderStub $model
   * The data context of the tests.
   */
  private $model;

  /**
   * Tests the `findViewFile` method.
   */
  public function testFindViewFile() {
    $expected = str_replace('/', DIRECTORY_SEPARATOR, \Yii::$app->viewPath.'/view.php');
    $this->assertEquals($expected, $this->model->findViewFile('//view'));

    $this->expectException(InvalidCallException::class);
    $this->model->findViewFile('/view');
  }

  /**
   * Tests the `load` method.
   */
  public function testLoad() {
    $this->expectException(InvalidCallException::class);
    $this->model->load('view');
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp() {
    $this->model = new LoaderStub(new ViewRenderer());
  }
}

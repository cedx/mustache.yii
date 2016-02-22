<?php
/**
 * @file
 * Implementation of the `yii\test\mustache\LoaderTest` class.
 */
namespace yii\test\mustache;

// Dependencies.
use yii\mustache\Loader;
use yii\mustache\ViewRenderer;

/**
 * Publicly exposes the features of the `yii\mustache\Loader class.
 */
class LoaderStub extends Loader {

  /**
   * Finds the view file based on the given view name.
   * @param string $name The view name.
   * @return string The view file path.
   */
  public function findViewFile($name) {
    return parent::findViewFile($name);
  }
}

/**
 * Tests the features of the `yii\mustache\Loader` class.
 */
class LoaderTest extends \PHPUnit_Framework_TestCase {

  /**
   * @var yii::test::mustache::LoaderStub $model
   * The data context of the tests.
   */
  private $model;

  /**
   * Tests the `findViewFile` method.
   */
  public function testFindViewFile() {
    $expected = str_replace('/', DIRECTORY_SEPARATOR, \Yii::$app->viewPath.'/view.php');
    $this->assertEquals($expected, $this->model->findViewFile('//view'));

    $this->setExpectedException('yii\base\InvalidCallException');
    $this->model->findViewFile('/view');
  }

  /**
   * Tests the `load` method.
   */
  public function testLoad() {
    $this->setExpectedException('yii\base\InvalidCallException');
    $this->model->load('view');
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp() {
    $this->model = new LoaderStub(new ViewRenderer());
  }
}

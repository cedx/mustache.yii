<?php
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
   * @test Loader::findViewFile
   */
  public function testFindViewFile() {
    $findViewFile = function(string $name) {
      return $this->findViewFile($name);
    };

    $expected = str_replace('/', DIRECTORY_SEPARATOR, \Yii::$app->getViewPath().'/view.php');
    $this->assertEquals($expected, $findViewFile->call($this->model, '//view'));

    $this->expectException(InvalidCallException::class);
    $findViewFile->call($this->model, '/view');
  }

  /**
   * @test Loader::load
   */
  public function testLoad() {
    $this->expectException(InvalidCallException::class);
    $this->model->load('view');
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp() {
    $this->model = new Loader(['viewRenderer' => \Yii::createObject(ViewRenderer::class)]);
  }
}

<?php
declare(strict_types=1);
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
   * Tests the `Loader::findViewFile
   */
  function testFindViewFile(): void {
    $findViewFile = function($name) {
      return $this->findViewFile($name);
    };

    // It should return the path of the corresponding view file.
      assertThat($findViewFile->call($this->model, '//view'), equalTo(str_replace('/', DIRECTORY_SEPARATOR, \Yii::$app->viewPath.'/view.php'));
    });

    // It should throw an exception if the view file is not found.
      assertThat(function() use ($findViewFile) { $findViewFile->call($this->model, '/view'); })->to->throw(InvalidCallException::class));
    });
  }

  /**
   * Tests the `Loader::load
   */
  function testLoad(): void {
    // It should throw an exception if the view file is not found.
      assertThat(function() { $this->model->load('view'); })->to->throw(InvalidCallException::class));
    });
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp(): void {
    $this->model = new Loader(['viewRenderer' => new ViewRenderer]);
  }
}

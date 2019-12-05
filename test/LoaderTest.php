<?php declare(strict_types=1);
namespace yii\mustache;

use function PHPUnit\Expect\{expect, it};
use PHPUnit\Framework\{TestCase};
use yii\base\{View, ViewNotFoundException};

/** @testdox yii\mustache\Loader */
class LoaderTest extends TestCase {

  /** @var Loader The data context of the tests. */
  private Loader $model;

  /** @testdox ->load() */
  function testLoad(): void {
    it('should throw an exception if the view file is not found', function() {
      expect(fn() => $this->model->load('//view'))->to->throw(ViewNotFoundException::class);
    });
  }

  /** @before This method is called before each test. */
  protected function setUp(): void {
    $viewRenderer = new ViewRenderer(['view' => new View]);
    $this->model = new Loader(['viewRenderer' => $viewRenderer]);
  }
}

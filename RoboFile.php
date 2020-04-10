<?php declare(strict_types=1);
use Robo\{Result, Tasks};

// Load the dependencies.
require_once __DIR__.'/vendor/autoload.php';

/** Provides tasks for the build system. */
class RoboFile extends Tasks {

  /** Creates a new task runner. */
  function __construct() {
    $path = (string) getenv('PATH');
    $vendor = (string) realpath('vendor/bin');
    if (mb_strpos($path, $vendor) === false) putenv("PATH=$vendor".PATH_SEPARATOR.$path);
    $this->stopOnFail();
  }

  /**
   * Deletes all generated files and reset any saved state.
   * @return Result The task result.
   */
  function clean(): Result {
    return $this->collectionBuilder()
      ->addTask($this->taskCleanDir('var'))
      ->addTask($this->taskDeleteDir(['build', 'doc/api', 'web']))
      ->run();
  }

  /**
   * Uploads the results of the code coverage.
   * @return Result The task result.
   */
  function coverage(): Result {
    return $this->_exec('coveralls var/coverage.xml');
  }

  /**
   * Builds the documentation.
   * @return Result The task result.
   */
  function doc(): Result {
    $phpdoc = PHP_OS_FAMILY == 'Windows' ? 'php '.escapeshellarg('C:\Program Files\PHP\share\phpDocumentor.phar') : 'phpdoc';
    return $this->collectionBuilder()
      ->addTask($this->taskFilesystemStack()
        ->copy('CHANGELOG.md', 'doc/about/changelog.md')
        ->copy('LICENSE.md', 'doc/about/license.md'))
      ->addTask($this->taskExec("$phpdoc --config=etc/phpdoc.xml"))
      ->addTask($this->taskExec('mkdocs build --config-file=doc/mkdocs.yaml'))
      ->addTask($this->taskFilesystemStack()
        ->remove(['doc/about/changelog.md', 'doc/about/license.md', 'www/mkdocs.yaml']))
      ->run();
  }

  /**
   * Performs the static analysis of source code.
   * @return Result The task result.
   */
  function lint(): Result {
    return $this->taskExecStack()
      ->exec('php -l example/main.php')
      ->exec('phpstan analyse --configuration=etc/phpstan.neon')
      ->run();
  }

  /**
   * Runs the test suites.
   * @return Result The task result.
   */
  function test(): Result {
    return $this->_exec('phpunit --configuration=etc/phpunit.xml');
  }

  /**
   * Upgrades the project to the latest revision.
   * @return Result The task result.
   */
  function upgrade(): Result {
    $composer = PHP_OS_FAMILY == 'Windows' ? 'php '.escapeshellarg('C:\Program Files\PHP\share\composer.phar') : 'composer';
    return $this->taskExecStack()
      ->exec('git reset --hard')
      ->exec('git fetch --all --prune')
      ->exec('git pull --rebase')
      ->exec("$composer update --no-interaction")
      ->run();
  }

  /**
   * Increments the version number of the package.
   * @param string $component The part in the version number to increment.
   * @return Result The task result.
   */
  function version(string $component = 'patch'): Result {
    $semverTask = $this->taskSemVer()->increment($component);
    $version = $semverTask->setFormat('%M.%m.%p')->__toString();
    return $this->collectionBuilder()
      ->addTask($semverTask)
      ->addTask($this->taskReplaceInFile('etc/phpdoc.xml')->regex('/version number="\d+(\.\d+){2}"/')->to("version number=\"$version\""))
      ->run();
  }
}

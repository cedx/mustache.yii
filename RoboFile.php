<?php
declare(strict_types=1);
use Robo\{Result, Tasks};

// Load the dependencies.
require_once __DIR__.'/vendor/autoload.php';

/**
 * Provides tasks for the build system.
 */
class RoboFile extends Tasks {

  /**
   * Creates a new task runner.
   */
  function __construct() {
    $path = (string) getenv('PATH');
    $vendor = (string) realpath('vendor/bin');
    if (strpos($path, $vendor) === false) putenv("PATH=$vendor".PATH_SEPARATOR.$path);
  }

  /**
   * Deletes all generated files and reset any saved state.
   */
  function clean(): void {
    $this->_cleanDir('var');
    $this->_deleteDir(['build', 'doc/api', 'web']);
  }

  /**
   * Uploads the results of the code coverage.
   */
  function coverage(): void {
    $this->_exec('coveralls var/coverage.xml');
  }

  /**
   * Builds the documentation.
   */
  function doc(): void {
    $this->taskFilesystemStack()
      ->copy('CHANGELOG.md', 'doc/about/changelog.md')
      ->copy('LICENSE.md', 'doc/about/license.md')
      ->run();

    $this->_exec('phpdoc');
    $this->_exec('mkdocs build');
  }

  /**
   * Performs the static analysis of source code.
   */
  function lint(): void {
    $this->_exec('php -l example/main.php');
    $this->_exec('phpstan analyse');
  }

  /**
   * Runs the test suites.
   * @return Result The task result.
   */
  function test(): Result {
    return $this->taskPhpUnit()->run();
  }

  /**
   * Upgrades the project to the latest revision.
   */
  function upgrade(): void {
    $composer = escapeshellarg(PHP_OS_FAMILY == 'Windows' ? 'C:\Program Files\PHP\share\composer.phar' : '/usr/local/bin/composer');
    $this->taskExecStack()->stopOnFail()
      ->exec('git reset --hard')
      ->exec('git fetch --all --prune')
      ->exec('git pull --rebase')
      ->exec("php $composer update --no-interaction")
      ->run();
  }

  /**
   * Increments the version number of the package.
   * @param string $component The part in the version number to increment.
   */
  function version(string $component = 'patch'): void {
    $this->taskSemVer('.semver')->increment($component)->run();
  }

  /**
   * Watches for file changes.
   */
  function watch(): void {
    $this->taskWatch()
      ->monitor(['lib', 'test'], function() { $this->test(); })
      ->run();
  }
}

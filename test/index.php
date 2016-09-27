<?php
/**
 * Entry point of the unit tests.
 */
use yii\console\{Application};

// Set the environment.
define('YII_DEBUG', true);
define('YII_ENV', getenv('YII_ENV') ?: 'test');

// Load the class library.
$rootPath = dirname(__DIR__);
require_once "$rootPath/vendor/autoload.php";
require_once "$rootPath/vendor/yiisoft/yii2/Yii.php";

// Initialize the application.
Yii::setAlias('@root', $rootPath);
new Application([
  'id' => 'yii2-mustache',
  'basePath' => '@root/lib',
  'vendorPath' => '@root/vendor'
]);

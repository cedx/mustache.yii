<?php declare(strict_types=1);
use yii\console\{Application};

// Set the environment.
define('YII_DEBUG', true);
define('YII_ENV', 'test');

// Load the class library.
$rootPath = dirname(__DIR__);
require_once "$rootPath/vendor/autoload.php";
require_once "$rootPath/vendor/yiisoft/yii2/Yii.php";
Yii::setAlias('@root', $rootPath);
Yii::setAlias('@yii/mustache', "$rootPath/lib");

// Start the application.
new Application(['id' => 'yii2-mustache', 'basePath' => '@root/lib']);

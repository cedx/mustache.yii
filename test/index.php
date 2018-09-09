<?php
declare(strict_types=1);

// Set the environment.
define('YII_DEBUG', true);
define('YII_ENV', 'test');

// Load the class library.
$rootPath = dirname(__DIR__);
require_once "$rootPath/vendor/autoload.php";
Yii::setAlias('@root', $rootPath);

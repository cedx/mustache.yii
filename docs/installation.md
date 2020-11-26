# Installation

## Requirements
Before installing **Mustache for Yii**, you need to make sure you have [PHP](https://www.php.net)
and [Composer](https://getcomposer.org), the PHP package manager, up and running.

You can verify if you're already good to go with the following commands:

```shell
php --version
# PHP 8.0.0 (cli) (built: Nov 24 2020 22:02:58) ( NTS Visual C++ 2019 x64 )

composer --version
# Composer version 2.0.7 2020-11-13 17:31:06
```

?> If you plan to play with the package sources, you will also need the latest versions of [PowerShell](https://docs.microsoft.com/en-us/powershell).

## Installing with Composer package manager

### 1. Install it
From a command prompt, run:

```shell
composer require cedx/yii2-mustache
```

### 2. Import it
Now in your [PHP](https://www.php.net) code, you can use:

```php
use yii\mustache\ViewRenderer;
```

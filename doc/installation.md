# Installation

## Requirements
Before installing **Mustache for Yii**, you need to make sure you have [PHP](https://www.php.net)
and [Composer](https://getcomposer.org), the PHP package manager, up and running.

!!! warning
    Mustache for Yii requires PHP >= **7.4.0**.

You can verify if you're already good to go with the following commands:

```shell
php --version
# PHP 7.4.3 (cli) (built: Feb 18 2020 17:29:57) ( NTS Visual C++ 2017 x64 )

composer --version
# Composer version 1.9.3 2020-02-04 12:58:49
```

!!! info
    If you plan to play with the package sources, you will also need
    [Robo](https://robo.li) and [Material for MkDocs](https://squidfunk.github.io/mkdocs-material).

## Installing with Composer package manager

### 1. Install it
From a command prompt, run:

```shell
composer require cedx/yii2-mustache
```

### 2. Import it
Now in your [PHP](https://www.php.net) code, you can use:

```php
<?php
use yii\mustache\{ViewRenderer};
```

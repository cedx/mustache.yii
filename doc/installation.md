# Installation

## Requirements
Before installing **Mustache for Yii**, you need to make sure you have [PHP](https://secure.php.net)
and [Composer](https://getcomposer.org), the PHP package manager, up and running.

!!! warning
    Mustache for Yii requires PHP >= **7.2.0**.

You can verify if you're already good to go with the following commands:

```shell
php --version
# PHP 7.2.10-0ubuntu0.18.04.1 (cli) (built: Sep 13 2018 13:45:02) ( NTS )

composer --version
# Composer version 1.7.2 2018-08-16 16:57:12
```

!!! info
    If you plan to play with the package sources, you will also need
    [Robo](https://robo.li) and [Material for MkDocs](https://squidfunk.github.io/mkdocs-material).

## Installing with Composer package manager

### 1. Install it
From a command prompt, run:

```shell
composer global require fxp/composer-asset-plugin
composer require cedx/yii2-mustache
```

### 2. Import it
Now in your [PHP](https://secure.php.net) code, you can use:

```php
<?php
use yii\mustache\{ViewRenderer};
```

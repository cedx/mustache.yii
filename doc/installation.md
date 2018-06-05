# Installation

## Requirements
Before installing **Mustache for Yii**, you need to make sure you have [PHP](https://secure.php.net)
and [Composer](https://getcomposer.org), the PHP package manager, up and running.

!!! warning
    Mustache for Yii requires PHP >= **7.2.0**.

You can verify if you're already good to go with the following commands:

```shell
php --version
# PHP 7.2.5-0ubuntu0.18.04.1 (cli) (built: May  9 2018 17:21:02) ( NTS )

composer --version
# Composer version 1.6.5 2018-05-04 11:44:59
```

!!! info
    If you plan to play with the package sources, you will also need
    [Phing](https://www.phing.info) and [Material for MkDocs](https://squidfunk.github.io/mkdocs-material).

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

# Mustache for Yii
![Runtime](https://img.shields.io/badge/php-%3E%3D7.1-brightgreen.svg) ![Release](https://img.shields.io/packagist/v/cedx/yii2-mustache.svg) ![License](https://img.shields.io/packagist/l/cedx/yii2-mustache.svg) ![Downloads](https://img.shields.io/packagist/dt/cedx/yii2-mustache.svg) ![Coverage](https://coveralls.io/repos/github/cedx/yii2-mustache/badge.svg) ![Build](https://travis-ci.org/cedx/yii2-mustache.svg)

[Mustache](http://mustache.github.io) templating for [Yii](http://www.yiiframework.com), high-performance [PHP](https://secure.php.net) framework.

This package provides a view renderer, the `yii\mustache\ViewRenderer` class.
This renderer allows to use [Mustache syntax](https://mustache.github.io/mustache.5.html) in view templates.

## Requirements
The latest [PHP](https://secure.php.net) and [Composer](https://getcomposer.org) versions.
If you plan to play with the sources, you will also need the latest [Phing](https://www.phing.info) version.

## Installing via [Composer](https://getcomposer.org)
From a command prompt, run:

```shell
$ composer global require fxp/composer-asset-plugin
$ composer require cedx/yii2-mustache
```

## Configuring application
In order to start using Mustache you need to configure the `view` application component, like the following:

```php
use yii\mustache\{ViewRenderer};
use yii\web\{View};

return [
  'components' => [
    'view' => [
      'class' => View::class,
      'renderers' => [
        'mustache' => ViewRenderer::class
      ]
    ]
  ]
];
```

After it's done you can create templates in files that have the `.mustache` extension (or use another file extension but
configure the component accordingly). Unlike standard view files, when using Mustache you must include the extension
in your `$this->render()` controller call:

```php
return $this->render('template.mustache', [ 'model' => 'The view model' ]);
```

## Template Syntax
The best resource to learn Mustache basics is its official documentation you can find at [mustache.github.io](http://mustache.github.io). Additionally there are Yii-specific syntax extensions described below.

### Variables
Within Mustache templates the following variables are always defined:

- `app`: the [`Yii::$app`](http://www.yiiframework.com/doc-2.0/yii-baseyii.html#$app-detail) instance.
- `this`: the current [`View`](http://www.yiiframework.com/doc-2.0/yii-base-view.html) object.
- `yii.debug`: the `YII_DEBUG` constant.
- `yii.devEnv`: the `YII_ENV_DEV` constant.
- `yii.prodEnv`: the `YII_ENV_PROD` constant.
- `yii.testEnv`: the `YII_ENV_TEST` constant.

### Lambdas
- `format`: provides a set of commonly used data formatting methods.
- `html`: provides a set of methods for generating commonly used HTML tags.
- `i18n`: provides features related with internationalization (I18N) and localization (L10N).
- `url`: provides a set of methods for managing URLs.

### Partials
There are two ways of referencing partials:

```
{{> post }}
{{> @app/views/layouts/2columns }}
```

In the first case the view will be searched relatively to the current view path. For `post.mustache`
that means these will be searched in the same directory as the currently rendered template.

In the second case we're using path aliases. All the Yii aliases such as `@app` are available by default.

## See also
- [API reference](https://cedx.github.io/yii2-mustache)
- [Code coverage](https://coveralls.io/github/cedx/yii2-mustache)
- [Continuous integration](https://travis-ci.org/cedx/yii2-mustache)

## License
[Mustache for Yii](https://github.com/cedx/yii2-mustache) is distributed under the MIT License.

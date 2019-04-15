# Usage

## Configuring application
In order to start using [Mustache](https://mustache.github.io) you need to configure the `view` application component, like the following:

```php
<?php return [
  'components' => [
    'view' => [
      'class' => 'yii\web\View',
      'renderers' => [
        'mustache' => 'yii\mustache\ViewRenderer'
      ]
    ]
  ]
];
```

After it's done you can create templates in files that have the `.mustache` extension (or use another file extension but configure the component accordingly). Unlike standard view files, when using [Mustache](https://mustache.github.io) you must include the extension in your `$this->render()` controller call:

```php
<?php
use yii\web\{Controller, Response};

class AppController extends Controller {
  function actionIndex(): Response {
    return $this->render('template.mustache', ['model' => 'The view model']); 
  }
}
```

## Template syntax
The best resource to learn Mustache basics is its official documentation you can find at [mustache.github.io](https://mustache.github.io). Additionally there are Yii-specific syntax extensions described below.

### Variables
Within Mustache templates the following variables are always defined:

- `app`: the [`Yii::$app`](https://www.yiiframework.com/doc/api/2.0/yii-baseyii#$app-detail) instance.
- `this`: the current [`View`](https://www.yiiframework.com/doc/api/2.0/yii-base-view) object.

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

In the first case the view will be searched relatively to the current view path.
For `post.mustache` that means these will be searched in the same directory as the currently rendered template.

In the second case we're using path aliases. All the Yii aliases such as `@app` are available by default.

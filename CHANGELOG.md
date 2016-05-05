# Changelog
This file contains highlights of what changes on each version of the [Mustache.yii](https://github.com/cedx/mustache.yii) library.

#### Version 0.5.1
- Removed dependency on external [PHP Mess Detector](https://phpmd.org) and [PHPUnit](https://phpunit.de) interfaces.
- Upgraded the package dependencies.

#### Version 0.5.0
- Breaking change: using [PHP 7](http://php.net/manual/en/migration70.new-features.php) features, like scalar and return type declarations.

#### Version 0.4.3
- Added support for a default message category in I18N helper.

#### Version 0.4.2
- Added code coverage.
- Added new unit tests.
- Added support for [Travis CI](https://travis-ci.org) continuous integration.
- Changed licensing for the [Apache License Version 2.0](http://www.apache.org/licenses/LICENSE-2.0).
- Upgraded the package dependencies.

#### Version 0.4.1
- Added support for [SonarQube](http://www.sonarqube.org) code analyzer.
- Replaced the custom build scripts by [Phing](https://www.phing.info).

#### Version 0.4.0
- Dropped the development dependencies based on [Node.js](https://nodejs.org).
- Replaced the build system by custom scripts.
- Replaced the documentation system by [Doxygen](http://www.doxygen.org).

#### Version 0.3.0
- Breaking change: ported the library API to [Yii](http://www.yiiframework.com) version 2.
- Fixed [Bitbucket issue #1](https://bitbucket.org/cedx/mustache.yii/issue/1)
- Upgraded [Mustache](https://github.com/bobthecow/mustache.php) dependency to version 2.8.0.

#### Version 0.2.0
- Breaking change: ported the library API to [namespaces](http://php.net/manual/en/language.namespaces.php).

#### Version 0.1.1
- Added `CMustacheI18nHelper` helper for internationalization.
- Breaking change: moved `CMustacheHtmlHelper::getTranslate()` method to `CMustacheI18nHelper` class.
- Fixed [GitHub issue #1](https://github.com/cedx/mustache.yii/issues/1)
- Lowered the required [PHP](http://php.net) version.
- Upgraded [Mustache](https://github.com/bobthecow/mustache.php) dependency to version 2.7.0.

#### Version 0.1.0
- Initial release.

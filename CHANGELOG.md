# Changelog
This file contains highlights of what changes on each version of the [Mustache for Yii](https://github.com/cedx/yii2-mustache) library.

## Version 4.1.0
- Replaced the [Codacy](https://www.codacy.com) code coverage service by the [Coveralls](https://coveralls.io) one.
- Updated the package dependencies.

## Version 4.0.0
- Breaking change: removed the `toJSON()` methods.
- Removed the `final` modifier from the `jsonSerialize()` methods.

## Version 3.0.0
- Breaking change: modified the signature of some class constructors.
- Added public getters/setters to some private properties.
- Added a fluent interface to the setters.
- Added the `jsonSerialize()` and `toJSON()` methods.
- Updated the package dependencies.

## Version 2.0.0
- Breaking change: moved the `Helper` class to the `yii\mustache` namespace.
- Optimized the unit tests.
- Removed dependency on framework messages.

## Version 1.0.1
- Updated the package dependencies.

## Version 1.0.0
- First stable release.

## Version 0.5.3
- Code optimization.
- Updated the package dependencies.

## Version 0.5.2
- Replaced [Doxygen](http://www.doxygen.org) documentation generator by [phpDocumentor](https://www.phpdoc.org).

## Version 0.5.1
- Replaced [SonarQube](http://www.sonarqube.org) code analyzer by [Codacy](https://www.codacy.com) service.
- Renamed the project according to its [Composer](https://getcomposer.org) package name.
- Updated the package dependencies.

## Version 0.5.1
- Removed dependency on external [PHP Mess Detector](https://phpmd.org) and [PHPUnit](https://phpunit.de) interfaces.
- Updated the package dependencies.

## Version 0.5.0
- Breaking change: using [PHP 7](https://secure.php.net/manual/en/migration70.new-features.php) features, like scalar and return type declarations.

## Version 0.4.3
- Added support for a default message category in I18N helper.

## Version 0.4.2
- Added code coverage.
- Added new unit tests.
- Added support for [Travis CI](https://travis-ci.org) continuous integration.
- Changed licensing for the [Apache License Version 2.0](http://www.apache.org/licenses/LICENSE-2.0).
- Updated the package dependencies.

## Version 0.4.1
- Added support for [SonarQube](http://www.sonarqube.org) code analyzer.
- Replaced the custom build scripts by [Phing](https://www.phing.info).

## Version 0.4.0
- Dropped the development dependencies based on [Node.js](https://nodejs.org).
- Replaced the build system by custom scripts.
- Replaced the documentation system by [Doxygen](http://www.doxygen.org).

## Version 0.3.0
- Breaking change: ported the library API to [Yii](http://www.yiiframework.com) version 2.
- Updated [Mustache](https://github.com/bobthecow/mustache.php) dependency to version 2.8.0.

## Version 0.2.0
- Breaking change: ported the library API to [namespaces](https://secure.php.net/manual/en/language.namespaces.php).

## Version 0.1.1
- Added `CMustacheI18nHelper` helper for internationalization.
- Breaking change: moved `CMustacheHtmlHelper::getTranslate()` method to `CMustacheI18nHelper` class.
- Fixed [GitHub issue #1](https://github.com/cedx/yii2-mustache/issues/1)
- Lowered the required [PHP](https://secure.php.net) version.
- Updated [Mustache](https://github.com/bobthecow/mustache.php) dependency to version 2.7.0.

## Version 0.1.0
- Initial release.

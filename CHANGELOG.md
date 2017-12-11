# Changelog
This file contains highlights of what changes on each version of the [Mustache for Yii](https://github.com/cedx/yii2-mustache) library.

## Version [9.0.0](https://github.com/cedx/yii2-mustache/compare/v8.0.0...v9.0.0)
- Breaking change: classes extending from `yii\base\Object` now extends from `BaseObject`.
- Breaking change: raised the required [PHP](https://secure.php.net) version.
- Breaking change: using PHP 7.1 features, like nullable types and void functions.

## Version [8.0.0](https://github.com/cedx/yii2-mustache/compare/v7.0.0...v8.0.0)
- Breaking change: removed the `CACHE_KEY_PREFIX` constants.
- Breaking change: removed the `ViewRenderer::$cacheId` property.
- Added new unit tests.
- Added the `ViewRenderer::$cache` property.
- Added the `ViewRenderer::$enableCaching` property.
- Changed licensing for the [MIT License](https://opensource.org/licenses/MIT).

## Version [7.0.0](https://github.com/cedx/yii2-mustache/compare/v6.1.0...v7.0.0)
- Breaking change: renamed the `yii\mustache\helpers\HTML` class to `Html`.
- Breaking change: renamed the `yii\mustache\helpers\URL` class to `Url`.
- Updated the package dependencies.

## Version [6.1.0](https://github.com/cedx/yii2-mustache/compare/v6.0.0...v6.1.0)
- Enabled the strict typing.
- Replaced [phpDocumentor](https://www.phpdoc.org) documentation generator by [ApiGen](https://github.com/ApiGen/ApiGen).
- Updated the package dependencies.

## Version [6.0.0](https://github.com/cedx/yii2-mustache/compare/v5.0.0...v6.0.0)
- Breaking change: added `init()` methods for validating the required properties.
- Breaking change: the `Cache` class now extends from `Object` class, and implements the `Mustache_Cache` interface.
- Breaking change: the `Logger` class now extends from `Object` class, and implements the [PSR-3](http://www.php-fig.org/psr/psr-3) logger interface.
- Breaking change: replaced most of getters and setters by properties.
- Ported the unit test assertions from [TDD](https://en.wikipedia.org/wiki/Test-driven_development) to [BDD](https://en.wikipedia.org/wiki/Behavior-driven_development).
- Updated the package dependencies.

## Version [5.0.0](https://github.com/cedx/yii2-mustache/compare/v4.1.0...v5.0.0)
- Breaking change: changed the signature of the constructors of the `Cache` and `Logger` classes.
- Breaking change: removed the `jsonSerialize()` and `__toString()` methods.
- Updated the package dependencies.

## Version [4.1.0](https://github.com/cedx/yii2-mustache/compare/v4.0.0...v4.1.0)
- Replaced the [Codacy](https://www.codacy.com) code coverage service by the [Coveralls](https://coveralls.io) one.
- Updated the package dependencies.

## Version [4.0.0](https://github.com/cedx/yii2-mustache/compare/v3.0.0...v4.0.0)
- Breaking change: removed the `toJSON()` methods.
- Removed the `final` modifier from the `jsonSerialize()` methods.

## Version [3.0.0](https://github.com/cedx/yii2-mustache/compare/v2.0.0...v3.0.0)
- Breaking change: modified the signature of some class constructors.
- Added public getters/setters to some private properties.
- Added a fluent interface to the setters.
- Added the `jsonSerialize()` and `toJSON()` methods.
- Updated the package dependencies.

## Version [2.0.0](https://github.com/cedx/yii2-mustache/compare/v1.0.1...v2.0.0)
- Breaking change: moved the `Helper` class to the `yii\mustache` namespace.
- Optimized the unit tests.
- Removed dependency on framework messages.

## Version [1.0.1](https://github.com/cedx/yii2-mustache/compare/v1.0.0...v1.0.1)
- Updated the package dependencies.

## Version [1.0.0](https://github.com/cedx/yii2-mustache/compare/v0.5.3...v1.0.0)
- First stable release.

## Version [0.5.3](https://github.com/cedx/yii2-mustache/compare/v0.5.2...v0.5.3)
- Code optimization.
- Updated the package dependencies.

## Version [0.5.2](https://github.com/cedx/yii2-mustache/compare/v0.5.1...v0.5.2)
- Replaced [Doxygen](http://www.doxygen.org) documentation generator by [phpDocumentor](https://www.phpdoc.org).

## Version [0.5.1](https://github.com/cedx/yii2-mustache/compare/v0.5.0...v0.5.1)
- Removed dependency on external [PHP Mess Detector](https://phpmd.org) and [PHPUnit](https://phpunit.de) interfaces.
- Renamed the project according to its [Composer](https://getcomposer.org) package name.
- Replaced [SonarQube](http://www.sonarqube.org) code analyzer by [Codacy](https://www.codacy.com) service.
- Updated the package dependencies.

## Version [0.5.0](https://github.com/cedx/yii2-mustache/compare/v0.4.3...v0.5.0)
- Breaking change: using [PHP 7](https://secure.php.net/manual/en/migration70.new-features.php) features, like scalar and return type declarations.

## Version [0.4.3](https://github.com/cedx/yii2-mustache/compare/v0.4.2...v0.4.3)
- Added support for a default message category in I18N helper.

## Version [0.4.2](https://github.com/cedx/yii2-mustache/compare/v0.4.1...v0.4.2)
- Added code coverage.
- Added new unit tests.
- Added support for [Travis CI](https://travis-ci.org) continuous integration.
- Changed licensing for the [Apache License Version 2.0](http://www.apache.org/licenses/LICENSE-2.0).
- Updated the package dependencies.

## Version [0.4.1](https://github.com/cedx/yii2-mustache/compare/v0.4.0...v0.4.1)
- Added support for [SonarQube](http://www.sonarqube.org) code analyzer.
- Replaced the custom build scripts by [Phing](https://www.phing.info).

## Version [0.4.0](https://github.com/cedx/yii2-mustache/compare/v0.3.0...v0.4.0)
- Dropped the development dependencies based on [Node.js](https://nodejs.org).
- Replaced the build system by custom scripts.
- Replaced the documentation system by [Doxygen](http://www.doxygen.org).

## Version [0.3.0](https://github.com/cedx/yii2-mustache/compare/v0.2.0...v0.3.0)
- Breaking change: ported the library API to [Yii](http://www.yiiframework.com) version 2.
- Updated [Mustache](https://github.com/bobthecow/mustache.php) dependency to version 2.8.0.

## Version [0.2.0](https://github.com/cedx/yii2-mustache/compare/v0.1.1...v0.2.0)
- Breaking change: ported the library API to [namespaces](https://secure.php.net/manual/en/language.namespaces.php).

## Version [0.1.1](https://github.com/cedx/yii2-mustache/compare/v0.1.0...v0.1.1)
- Added `CMustacheI18nHelper` helper for internationalization.
- Breaking change: moved `CMustacheHtmlHelper::getTranslate()` method to `CMustacheI18nHelper` class.
- Fixed [GitHub issue #1](https://github.com/cedx/yii2-mustache/issues/1)
- Lowered the required [PHP](https://secure.php.net) version.
- Updated [Mustache](https://github.com/bobthecow/mustache.php) dependency to version 2.7.0.

## Version 0.1.0
- Initial release.

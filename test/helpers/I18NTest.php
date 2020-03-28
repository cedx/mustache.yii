<?php declare(strict_types=1);
namespace yii\mustache\helpers;

use PHPUnit\Framework\{TestCase};
use function PHPUnit\Framework\{assertThat, equalTo};

/** @testdox yii\mustache\helpers\I18N */
class I18NTest extends TestCase {

  /** @var \Mustache_LambdaHelper The engine used to render strings. */
  private \Mustache_LambdaHelper $helper;

  /** @testdox ->getTranslate() */
  function testGetTranslate(): void {
    // It should return the specified string if no translation is matching.
    $translation = \Yii::t('app', 'foo');
    assertThat($translation, equalTo('foo'));

    $i18n = new I18N;
    foreach ([$i18n->t, $i18n->translate] as $closure) {
      assertThat($closure('foo', $this->helper), equalTo($translation));
      assertThat($closure('app:foo', $this->helper), equalTo($translation));
      assertThat($closure('{"message": "foo"}', $this->helper), equalTo($translation));
      assertThat($closure('{"category": "app", "language": "en-US", "message": "foo"}', $this->helper), equalTo($translation));
    }

    // It should return the translated string if a translation is matching.
    $translation = \Yii::t('yii', 'Error', [], 'fr-FR');
    assertThat($translation, equalTo('Erreur'));

    $language = \Yii::$app->language;
    \Yii::$app->language = 'fr-FR';

    $i18n = new I18N(['defaultCategory' => 'yii']);
    foreach ([$i18n->t, $i18n->translate] as $closure) {
      assertThat($closure('Error', $this->helper), equalTo($translation));
      assertThat($closure('yii:Error', $this->helper), equalTo($translation));
      assertThat($closure('{"message": "Error"}', $this->helper), equalTo($translation));
      assertThat($closure('{"category": "yii", "language": "fr-FR", "message": "Error"}', $this->helper), equalTo($translation));
    }

    \Yii::$app->language = $language;
  }

  /** @before This method is called before each test. */
  protected function setUp(): void {
    $this->helper = new \Mustache_LambdaHelper(new \Mustache_Engine, new \Mustache_Context);
  }
}

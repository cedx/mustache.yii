<?php
declare(strict_types=1);
namespace yii\mustache\helpers;

use function PHPUnit\Expect\{expect, it};
use PHPUnit\Framework\{TestCase};

/**
 * Tests the features of the `yii\mustache\helpers\I18N` class.
 */
class I18NTest extends TestCase {

  /**
   * @var \Mustache_LambdaHelper The engine used to render strings.
   */
  private $helper;

  /**
   * @test I18N::getTranslate
   */
  public function testGetTranslate(): void {
    it('should return the specified string if no translation is matching', function() {
      $translation = \Yii::t('app', 'foo');
      expect($translation)->to->equal('foo');

      $i18n = new I18N;
      foreach ([$i18n->t, $i18n->translate] as $closure) {
        expect($closure('foo', $this->helper))->to->equal($translation);
        expect($closure('app:foo', $this->helper))->to->equal($translation);
        expect($closure('{"message": "foo"}', $this->helper))->to->equal($translation);
        expect($closure('{"category": "app", "language": "en-US", "message": "foo"}', $this->helper))->to->equal($translation);
      }
    });

    it('should return the translated string if a translation is matching', function() {
      $translation = \Yii::t('yii', 'Error', [], 'fr-FR');
      expect($translation)->to->equal('Erreur');

      $language = \Yii::$app->language;
      \Yii::$app->language = 'fr-FR';

      $i18n = new I18N(['defaultCategory' => 'yii']);
      foreach ([$i18n->t, $i18n->translate] as $closure) {
        expect($closure('Error', $this->helper))->to->equal($translation);
        expect($closure('yii:Error', $this->helper))->to->equal($translation);
        expect($closure('{"message": "Error"}', $this->helper))->to->equal($translation);
        expect($closure('{"category": "yii", "language": "fr-FR", "message": "Error"}', $this->helper))->to->equal($translation);
      }

      \Yii::$app->language = $language;
    });
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp(): void {
    $this->helper = new \Mustache_LambdaHelper(new \Mustache_Engine, new \Mustache_Context);
  }
}

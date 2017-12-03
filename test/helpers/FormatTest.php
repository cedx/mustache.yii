<?php
declare(strict_types=1);
namespace yii\mustache\helpers;

use function PHPUnit\Expect\{expect, it};
use PHPUnit\Framework\{TestCase};

/**
 * Tests the features of the `yii\mustache\helpers\Format` class.
 */
class FormatTest extends TestCase {

  /**
   * @var \Mustache_LambdaHelper The engine used to render strings.
   */
  private $helper;

  /**
   * @test Format::getBoolean
   */
  public function testGetBoolean(): void {
    it('should return "No" for a falsy value', function() {
      $closure = (new Format)->boolean;
      expect($closure(false, $this->helper))->to->equal('No');
      expect($closure(0, $this->helper))->to->equal('No');
    });

    it('should return "Yes" for a truthy value', function() {
      $closure = (new Format)->boolean;
      expect($closure(true, $this->helper))->to->equal('Yes');
      expect($closure(1, $this->helper))->to->equal('Yes');
    });
  }

  /**
   * @test Format::getCurrency
   */
  public function testGetCurrency(): void {
    it('should format the specified value as a currency', function() {
      $closure = (new Format)->currency;
      expect($closure('100', $this->helper))->to->equal('$100.00');
      expect($closure('{"value": 1234.56, "currency": "EUR"}', $this->helper))->to->equal('€1,234.56');
    });
  }

  /**
   * @test Format::getDate
   */
  public function testGetDate(): void {
    it('should format the specified value as a date', function() {
      $closure = (new Format)->date;
      expect($closure('1994-11-05T13:15:30Z', $this->helper))->to->equal('Nov 5, 1994');
    });
  }

  /**
   * @test Format::getDecimal
   */
  public function testGetDecimal(): void {
    it('should format the specified value as a decimal number', function() {
      $closure = (new Format)->decimal;
      expect($closure('100', $this->helper))->to->equal('100.00');
      expect($closure('1234.56', $this->helper))->to->equal('1,234.56');
    });
  }

  /**
   * @test Format::getInteger
   */
  public function testGetInteger(): void {
    it('should format the specified value as an integer number', function() {
      $closure = (new Format)->integer;
      expect($closure('100', $this->helper))->to->equal('100');
      expect($closure('-1234.56', $this->helper))->to->equal('-1,234');
    });
  }

  /**
   * @test Format::getNtext
   */
  public function testGetNtext(): void {
    it('should replace new lines by "<br>" tags', function() {
      $closure = (new Format)->ntext;
      expect($closure("Foo\nBar", $this->helper))->to->equal('Foo<br>Bar');
      expect($closure("Foo\r\nBaz", $this->helper))->to->equal('Foo<br>Baz');
    });
  }

  /**
   * @test Format::getPercent
   */
  public function testGetPercent(): void {
    it('should format the specified value as a percentage', function() {
      $closure = (new Format)->percent;
      expect($closure('0.1', $this->helper))->to->equal('10%');
      expect($closure('1.23', $this->helper))->to->equal('123%');
    });
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp(): void {
    $this->helper = new \Mustache_LambdaHelper(new \Mustache_Engine, new \Mustache_Context);
  }
}

<?php
namespace yii\mustache\helpers;
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
  public function testGetBoolean() {
    it('should return "No" for a falsy value', function() {
      $closure = (new Format())->boolean;
      $this->assertEquals('No', $closure(false, $this->helper));
      $this->assertEquals('No', $closure(0, $this->helper));
    });

    it('should return "Yes" for a truthy value', function() {
      $closure = (new Format())->boolean;
      $this->assertEquals('Yes', $closure(true, $this->helper));
      $this->assertEquals('Yes', $closure(1, $this->helper));
    });
  }

  /**
   * @test Format::getCurrency
   */
  public function testGetCurrency() {
    it('should TODO', function() {
      $closure = (new Format())->currency;
      $this->assertEquals('$100.00', $closure('100', $this->helper));
      $this->assertEquals('€1,234.56', $closure('{"value": 1234.56, "currency": "EUR"}', $this->helper));
    });
  }

  /**
   * @test Format::getDate
   */
  public function testGetDate() {
    it('should TODO', function() {
      $closure = (new Format())->date;
      $this->assertEquals('Nov 5, 1994', $closure('1994-11-05T13:15:30Z', $this->helper));
    });
  }

  /**
   * @test Format::getDecimal
   */
  public function testGetDecimal() {
    it('should TODO', function() {
      $closure = (new Format())->decimal;
      $this->assertEquals('100.00', $closure('100', $this->helper));
      $this->assertEquals('1,234.56', $closure('1234.56', $this->helper));
    });
  }

  /**
   * @test Format::getInteger
   */
  public function testGetInteger() {
    it('should TODO', function() {
      $closure = (new Format())->integer;
      $this->assertEquals('100', $closure('100', $this->helper));
      $this->assertEquals('-1,234', $closure('-1234.56', $this->helper));
    });
  }

  /**
   * @test Format::getNtext
   */
  public function testGetNtext() {
    it('should TODO', function() {
      $closure = (new Format())->ntext;
      $this->assertEquals('Foo<br>Bar', $closure("Foo\nBar", $this->helper));
      $this->assertEquals('Foo<br>Baz', $closure("Foo\r\nBaz", $this->helper));
    });
  }

  /**
   * @test Format::getPercent
   */
  public function testGetPercent() {
    it('should TODO', function() {
      $closure = (new Format())->percent;
      $this->assertEquals('10%', $closure('0.1', $this->helper));
      $this->assertEquals('123%', $closure('1.23', $this->helper));
    });
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp() {
    $this->helper = \Yii::createObject(
      \Mustache_LambdaHelper::class,
      [\Yii::createObject(\Mustache_Engine::class), \Yii::createObject(\Mustache_Context::class)]
    );
  }
}

<?php
/**
 * Implementation of the `yii\test\mustache\helpers\FormatTest` class.
 */
namespace yii\test\mustache\helpers;
use yii\mustache\helpers\{Format};

/**
 * Tests the features of the `yii\mustache\helpers\Format` class.
 */
class FormatTest extends \PHPUnit_Framework_TestCase {

  /**
   * @var \Mustache_LambdaHelper $helper
   * The engine used to render strings.
   */
  private $helper;

  /**
   * Tests the `Format::getBoolean()` method.
   */
  public function testGetBoolean() {
    $closure = (new Format())->getBoolean();
    $this->assertEquals('No', $closure(false, $this->helper));
    $this->assertEquals('No', $closure(0, $this->helper));
    $this->assertEquals('Yes', $closure(true, $this->helper));
    $this->assertEquals('Yes', $closure(1, $this->helper));
  }

  /**
   * Tests the `Format::getCurrency()` method.
   */
  public function testGetCurrency() {
    $closure = (new Format())->getCurrency();
    $this->assertEquals('$100.00', $closure('100', $this->helper));
    $this->assertEquals('€1,234.56', $closure('{"value": 1234.56, "currency": "EUR"}', $this->helper));
  }

  /**
   * Tests the `Format::getDate()` method.
   */
  public function testGetDate() {
    $closure = (new Format())->getDate();
    $this->assertEquals('Nov 5, 1994', $closure('1994-11-05T13:15:30Z', $this->helper));
  }

  /**
   * Tests the `Format::getDecimal()` method.
   */
  public function testGetDecimal() {
    $closure = (new Format())->getDecimal();
    $this->assertEquals('100.00', $closure('100', $this->helper));
    $this->assertEquals('1,234.56', $closure('1234.56', $this->helper));
  }

  /**
   * Tests the `Format::getInteger()` method.
   */
  public function testGetInteger() {
    $closure = (new Format())->getInteger();
    $this->assertEquals('100', $closure('100', $this->helper));
    $this->assertEquals('-1,234', $closure('-1234.56', $this->helper));
  }

  /**
   * Tests the `Format::getNtext()` method.
   */
  public function testGetNtext() {
    $closure = (new Format())->getNtext();
    $this->assertEquals('Foo<br>Bar', $closure("Foo\nBar", $this->helper));
    $this->assertEquals('Foo<br>Baz', $closure("Foo\r\nBaz", $this->helper));
  }

  /**
   * Tests the `Format::getPercent()` method.
   */
  public function testGetPercent() {
    $closure = (new Format())->getPercent();
    $this->assertEquals('10%', $closure('0.1', $this->helper));
    $this->assertEquals('123%', $closure('1.23', $this->helper));
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp() {
    $this->helper = new \Mustache_LambdaHelper(new \Mustache_Engine(), new \Mustache_Context());
  }
}

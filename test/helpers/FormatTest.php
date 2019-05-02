<?php declare(strict_types=1);
namespace yii\mustache\helpers;

use PHPUnit\Framework\{TestCase};

/** Tests the features of the `yii\mustache\helpers\Format` class. */
class FormatTest extends TestCase {

  /** @var \Mustache_LambdaHelper The engine used to render strings. */
  private $helper;

  /** @test Format->getBoolean() */
  function testGetBoolean(): void {
    // It should return "No" for a falsy value.
    $closure = (new Format)->boolean;
    assertThat($closure(false, $this->helper), equalTo('No'));
    assertThat($closure(0, $this->helper), equalTo('No'));

    // It should return "Yes" for a truthy value.
    $closure = (new Format)->boolean;
    assertThat($closure(true, $this->helper), equalTo('Yes'));
    assertThat($closure(1, $this->helper), equalTo('Yes'));
  }

  /** @test Format->getCurrency() */
  function testGetCurrency(): void {
    // It should format the specified value as a currency.
    $closure = (new Format)->currency;
    assertThat($closure('100', $this->helper), equalTo('$100.00'));
    assertThat($closure('{"value": 1234.56, "currency": "EUR"}', $this->helper), equalTo('€1,234.56'));
  }

  /** @test Format->getDate() */
  function testGetDate(): void {
    // It should format the specified value as a date.
    $closure = (new Format)->date;
    assertThat($closure('1994-11-05T13:15:30Z', $this->helper), equalTo('Nov 5, 1994'));
  }

  /** @test Format->getDecimal() */
  function testGetDecimal(): void {
    // It should format the specified value as a decimal number.
    $closure = (new Format)->decimal;
    assertThat($closure('1234.56', $this->helper), equalTo('1,234.56'));
    assertThat($closure('{"value": 100, "decimals": 4}', $this->helper), equalTo('100.0000'));
  }

  /** @test Format->getInteger() */
  function testGetInteger(): void {
    // It should format the specified value as an integer number.
    $closure = (new Format)->integer;
    assertThat($closure('100', $this->helper), equalTo('100'));
    assertThat($closure('-1234.56', $this->helper), equalTo('-1,234'));
  }

  /** @test Format->getNtext() */
  function testGetNtext(): void {
    // It should replace new lines by "<br>" tags.
    $closure = (new Format)->ntext;
    assertThat($closure("Foo\nBar", $this->helper), equalTo('Foo<br>Bar'));
    assertThat($closure("Foo\r\nBaz", $this->helper), equalTo('Foo<br>Baz'));
  }

  /** @test Format->getPercent() */
  function testGetPercent(): void {
    // It should format the specified value as a percentage.
    $closure = (new Format)->percent;
    assertThat($closure('0.1', $this->helper), equalTo('10%'));
    assertThat($closure('1.23', $this->helper), equalTo('123%'));
  }

  /** @before This method is called before each test. */
  protected function setUp(): void {
    $this->helper = new \Mustache_LambdaHelper(new \Mustache_Engine, new \Mustache_Context);
  }
}

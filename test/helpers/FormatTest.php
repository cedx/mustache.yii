<?php declare(strict_types=1);
namespace yii\mustache\helpers;

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\{assertThat, equalTo, logicalOr};

/** @testdox yii\mustache\helpers\Format */
class FormatTest extends TestCase {

	/** @var \Mustache_LambdaHelper The engine used to render strings. */
	private \Mustache_LambdaHelper $helper;

	/** @testdox ->getBoolean() */
	function testGetBoolean(): void {
		// It should return "No" for a falsy value.
		$closure = (new Format)->getBoolean();
		assertThat($closure(false, $this->helper), equalTo("No"));
		assertThat($closure(0, $this->helper), equalTo("No"));

		// It should return "Yes" for a truthy value.
		$closure = (new Format)->getBoolean();
		assertThat($closure(true, $this->helper), equalTo("Yes"));
		assertThat($closure(1, $this->helper), equalTo("Yes"));
	}

	/** @testdox ->getCurrency() */
	function testGetCurrency(): void {
		// It should format the specified value as a currency.
		$closure = (new Format)->getCurrency();
		assertThat($closure("100", $this->helper), logicalOr(equalTo("$100.00"), equalTo("USD 100.00")));
		assertThat($closure('{"value": 1234.56, "currency": "EUR"}', $this->helper), logicalOr(equalTo("€1,234.56"), equalTo("EUR 1,234.56")));
	}

	/** @testdox ->getDate() */
	function testGetDate(): void {
		// It should format the specified value as a date.
		$closure = (new Format)->getDate();
		assertThat($closure("1994-11-05T13:15:30Z", $this->helper), equalTo("Nov 5, 1994"));
	}

	/** @testdox ->getDecimal() */
	function testGetDecimal(): void {
		// It should format the specified value as a decimal number.
		$closure = (new Format)->getDecimal();
		assertThat($closure("1234.56", $this->helper), equalTo("1,234.56"));
		assertThat($closure('{"value": 100, "decimals": 4}', $this->helper), equalTo("100.0000"));
	}

	/** @testdox ->getInteger() */
	function testGetInteger(): void {
		// It should format the specified value as an integer number.
		$closure = (new Format)->getInteger();
		assertThat($closure("100", $this->helper), equalTo("100"));
		assertThat($closure("-1234.56", $this->helper), equalTo("-1,234"));
	}

	/** @testdox ->getNtext() */
	function testGetNtext(): void {
		// It should replace new lines by "<br>" tags.
		$closure = (new Format)->getNtext();
		assertThat($closure("Foo\nBar", $this->helper), equalTo("Foo<br>Bar"));
		assertThat($closure("Foo\r\nBaz", $this->helper), equalTo("Foo<br>Baz"));
	}

	/** @testdox ->getPercent() */
	function testGetPercent(): void {
		// It should format the specified value as a percentage.
		$closure = (new Format)->getPercent();
		assertThat($closure("0.1", $this->helper), equalTo("10%"));
		assertThat($closure("1.23", $this->helper), equalTo("123%"));
	}

	/** @before This method is called before each test. */
	protected function setUp(): void {
		\Yii::$app->getFormatter()->currencyCode = "USD";
		$this->helper = new \Mustache_LambdaHelper(new \Mustache_Engine, new \Mustache_Context);
	}
}

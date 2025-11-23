<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use MarkIngman\Fields\Element\DateFieldElement;
use MarkIngman\Fields\Element\TextFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class DateFieldMeldTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(DateFieldMeld::class, new DateFieldMeld());
	}

	public function testInvalidArgument(): void
	{
		$M = new DateFieldMeld();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . DateFieldElement::class);

		$M(new Fields(), new TextFieldElement(), null);
	}

	public function testIgnoreDisabled(): void
	{
		$E = new DateFieldElement(disabled: true);

		$M = $E->get_meld();
		$M(new Fields(), $E, '2000-01-01');

		$this->assertEquals('', $E->value);
	}
}

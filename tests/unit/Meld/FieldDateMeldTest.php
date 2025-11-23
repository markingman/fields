<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use MarkIngman\Fields\Element\FieldDateElement;
use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class FieldDateMeldTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(FieldDateMeld::class, new FieldDateMeld());
	}

	public function testInvalidArgument(): void
	{
		$M = new FieldDateMeld();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . FieldDateElement::class);

		$M(new Fields(), new FieldTextElement(), null);
	}

	public function testIgnoreDisabled(): void
	{
		$E = new FieldDateElement(disabled: true);

		$M = $E->get_meld();
		$M(new Fields(), $E, '2000-01-01');

		$this->assertEquals('', $E->value);
	}
}

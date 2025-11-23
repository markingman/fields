<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use MarkIngman\Fields\Element\FieldArrayElement;
use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class FieldArrayMeldTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(FieldArrayMeld::class, new FieldArrayMeld());
	}

	public function testInvalidArgument(): void
	{
		$M = new FieldArrayMeld();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . FieldArrayElement::class);

		$M(new Fields(), new FieldTextElement(), null);
	}

	public function testIgnoreDisabled(): void
	{
		$E = new FieldArrayElement(disabled: true);

		$M = $E->get_meld();
		$M(new Fields(), $E, ['a', 'b']);

		$this->assertEquals([], $E->value);
	}
}

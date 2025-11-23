<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use MarkIngman\Fields\Element\ArrayFieldElement;
use MarkIngman\Fields\Element\TextFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class ArrayFieldMeldTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(ArrayFieldMeld::class, new ArrayFieldMeld());
	}

	public function testInvalidArgument(): void
	{
		$M = new ArrayFieldMeld();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . ArrayFieldElement::class);

		$M(new Fields(), new TextFieldElement(), null);
	}

	public function testIgnoreDisabled(): void
	{
		$E = new ArrayFieldElement(disabled: true);

		$M = $E->get_meld();
		$M(new Fields(), $E, ['a', 'b']);

		$this->assertEquals([], $E->value);
	}
}

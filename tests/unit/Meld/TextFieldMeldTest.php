<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use MarkIngman\Fields\Element\ArrayFieldElement;
use MarkIngman\Fields\Element\TextFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class TextFieldMeldTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(TextFieldMeld::class, new TextFieldMeld());
	}

	public function testInvalidArgument(): void
	{
		$M = new TextFieldMeld();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . TextFieldElement::class);

		$M(new Fields(), new ArrayFieldElement(), null);
	}

	public function testIgnoreDisabled(): void
	{
		$E = new TextFieldElement(disabled: true);

		$M = $E->get_meld();
		$M(new Fields(), $E, 'test');

		$this->assertEquals('', $E->value);
	}
}

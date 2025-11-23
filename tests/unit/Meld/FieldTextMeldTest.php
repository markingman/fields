<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use MarkIngman\Fields\Element\FieldArrayElement;
use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class FieldTextMeldTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(FieldTextMeld::class, new FieldTextMeld());
	}

	public function testInvalidArgument(): void
	{
		$M = new FieldTextMeld();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . FieldTextElement::class);

		$M(new Fields(), new FieldArrayElement(), null);
	}

	public function testIgnoreDisabled(): void
	{
		$E = new FieldTextElement(disabled: true);

		$M = $E->get_meld();
		$M(new Fields(), $E, 'test');

		$this->assertEquals('', $E->value);
	}
}

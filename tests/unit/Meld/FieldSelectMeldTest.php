<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use MarkIngman\Fields\Element\FieldSelectElement;
use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class FieldSelectMeldTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(FieldSelectMeld::class, new FieldSelectMeld());
	}

	public function testInvalidArgument(): void
	{
		$M = new FieldSelectMeld();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . FieldSelectElement::class);

		$M(new Fields(), new FieldTextElement(), null);
	}

	public function testIgnoreDisabled(): void
	{
		$E = new FieldSelectElement(disabled: true, options: ['' => '', 'a' => 'A', 'b' => 'B']);

		$M = $E->get_meld();
		$M(new Fields(), $E, ['a', 'b']);

		$this->assertEquals('', $E->value);
	}
}

<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use MarkIngman\Fields\Element\SelectFieldElement;
use MarkIngman\Fields\Element\TextFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class SelectFieldMeldTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(SelectFieldMeld::class, new SelectFieldMeld());
	}

	public function testInvalidArgument(): void
	{
		$M = new SelectFieldMeld();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . SelectFieldElement::class);

		$M(new Fields(), new TextFieldElement(), null);
	}

	public function testIgnoreDisabled(): void
	{
		$E = new SelectFieldElement(disabled: true, options: ['' => '', 'a' => 'A', 'b' => 'B']);

		$M = $E->get_meld();
		$M(new Fields(), $E, ['a', 'b']);

		$this->assertEquals('', $E->value);
	}
}

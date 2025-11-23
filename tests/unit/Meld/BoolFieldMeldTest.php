<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use MarkIngman\Fields\Element\BoolFieldElement;
use MarkIngman\Fields\Element\TextFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class BoolFieldMeldTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(BoolFieldMeld::class, new BoolFieldMeld());
	}

	public function testInvalidArgument(): void
	{
		$M = new BoolFieldMeld();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . BoolFieldElement::class);

		$M(new Fields(), new TextFieldElement(), null);
	}

	public function testIgnoreDisabled(): void
	{
		$E = new BoolFieldElement(disabled: true);

		$M = $E->get_meld();
		$M(new Fields(), $E, 'yes');

		$this->assertEquals('', $E->value);
	}
}

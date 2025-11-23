<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use MarkIngman\Fields\Element\FieldBoolElement;
use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class FieldBoolMeldTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(FieldBoolMeld::class, new FieldBoolMeld());
	}

	public function testInvalidArgument(): void
	{
		$M = new FieldBoolMeld();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . FieldBoolElement::class);

		$M(new Fields(), new FieldTextElement(), null);
	}

	public function testIgnoreDisabled(): void
	{
		$E = new FieldBoolElement(disabled: true);

		$M = $E->get_meld();
		$M(new Fields(), $E, 'yes');

		$this->assertEquals('', $E->value);
	}
}

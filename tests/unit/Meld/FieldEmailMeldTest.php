<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use MarkIngman\Fields\Element\FieldEmailElement;
use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class FieldEmailMeldTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(FieldEmailMeld::class, new FieldEmailMeld());
	}

	public function testInvalidArgument(): void
	{
		$M = new FieldEmailMeld();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . FieldEmailElement::class);

		$M(new Fields(), new FieldTextElement(), null);
	}

	public function testIgnoreDisabled(): void
	{
		$E = new FieldEmailElement(disabled: true);

		$M = $E->get_meld();
		$M(new Fields(), $E, 'test@example.com');

		$this->assertEquals('', $E->value);
	}
}

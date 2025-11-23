<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use MarkIngman\Fields\Element\EmailFieldElement;
use MarkIngman\Fields\Element\TextFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class EmailFieldMeldTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(EmailFieldMeld::class, new EmailFieldMeld());
	}

	public function testInvalidArgument(): void
	{
		$M = new EmailFieldMeld();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . EmailFieldElement::class);

		$M(new Fields(), new TextFieldElement(), null);
	}

	public function testIgnoreDisabled(): void
	{
		$E = new EmailFieldElement(disabled: true);

		$M = $E->get_meld();
		$M(new Fields(), $E, 'test@example.com');

		$this->assertEquals('', $E->value);
	}
}

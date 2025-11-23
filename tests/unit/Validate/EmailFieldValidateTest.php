<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\EmailFieldElement;
use MarkIngman\Fields\Element\TextFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class EmailFieldValidateTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(EmailFieldValidate::class, new EmailFieldValidate());
	}

	public function testInvalidArgument(): void
	{
		$M = new EmailFieldValidate();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . EmailFieldElement::class);

		$M(new Fields(), new TextFieldElement());
	}
}

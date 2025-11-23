<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\ArrayFieldElement;
use MarkIngman\Fields\Element\TextFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class TextFieldValidateTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(TextFieldValidate::class, new TextFieldValidate());
	}

	public function testInvalidArgument(): void
	{
		$M = new TextFieldValidate();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . TextFieldElement::class);

		$M(new Fields(), new ArrayFieldElement());
	}
}

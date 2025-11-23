<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\SelectMultipleFieldElement;
use MarkIngman\Fields\Element\TextFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class SelectMultipleFieldValidateTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(SelectMultipleFieldValidate::class, new SelectMultipleFieldValidate());
	}

	public function testInvalidArgument(): void
	{
		$M = new SelectMultipleFieldValidate();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . SelectMultipleFieldElement::class);

		$M(new Fields(), new TextFieldElement());
	}
}

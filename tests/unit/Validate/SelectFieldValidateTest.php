<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\SelectFieldElement;
use MarkIngman\Fields\Element\TextFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class SelectFieldValidateTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(SelectFieldValidate::class, new SelectFieldValidate());
	}

	public function testInvalidArgument(): void
	{
		$M = new SelectFieldValidate();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . SelectFieldElement::class);

		$M(new Fields(), new TextFieldElement());
	}
}

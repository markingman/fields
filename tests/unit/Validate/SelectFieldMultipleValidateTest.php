<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\SelectFieldMultipleElement;
use MarkIngman\Fields\Element\TextFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class SelectFieldMultipleValidateTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(SelectFieldMultipleValidate::class, new SelectFieldMultipleValidate());
	}

	public function testInvalidArgument(): void
	{
		$M = new SelectFieldMultipleValidate();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . SelectFieldMultipleElement::class);

		$M(new Fields(), new TextFieldElement());
	}
}

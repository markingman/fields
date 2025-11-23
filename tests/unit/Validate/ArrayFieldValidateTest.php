<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\ArrayFieldElement;
use MarkIngman\Fields\Element\TextFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class ArrayFieldValidateTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(ArrayFieldValidate::class, new ArrayFieldValidate());
	}

	public function testInvalidArgument(): void
	{
		$M = new ArrayFieldValidate();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . ArrayFieldElement::class);

		$M(new Fields(), new TextFieldElement());
	}
}

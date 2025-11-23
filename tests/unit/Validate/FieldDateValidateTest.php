<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\FieldDateElement;
use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class FieldDateValidateTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(FieldDateValidate::class, new FieldDateValidate());
	}

	public function testInvalidArgument(): void
	{
		$M = new FieldDateValidate();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . FieldDateElement::class);

		$M(new Fields(), new FieldTextElement());
	}
}

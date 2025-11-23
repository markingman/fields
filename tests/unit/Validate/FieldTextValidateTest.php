<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\FieldArrayElement;
use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class FieldTextValidateTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(FieldTextValidate::class, new FieldTextValidate());
	}

	public function testInvalidArgument(): void
	{
		$M = new FieldTextValidate();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . FieldTextElement::class);

		$M(new Fields(), new FieldArrayElement());
	}
}

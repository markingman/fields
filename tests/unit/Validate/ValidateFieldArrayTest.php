<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class ValidateFieldArrayTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(ValidateFieldArray::class, new ValidateFieldArray());
	}

	public function testInvalidArgument(): void
	{
		$M = new ValidateFieldArray();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected FieldArrayElement');

		$M(new Fields(), new FieldTextElement());
	}
}

<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Validate\ValidateFieldArray;
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

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Expected FieldArrayElement');

		$M(new Fields(), new FieldTextElement());
	}
}

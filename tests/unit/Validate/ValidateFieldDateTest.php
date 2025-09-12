<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class ValidateFieldDateTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(ValidateFieldDate::class, new ValidateFieldDate());
	}

	public function testInvalidArgument(): void
	{
		$M = new ValidateFieldDate();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected FieldDateElement');

		$M(new Fields(), new FieldTextElement());
	}
}

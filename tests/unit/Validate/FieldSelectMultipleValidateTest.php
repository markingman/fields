<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\FieldSelectMultipleElement;
use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class FieldSelectMultipleValidateTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(FieldSelectMultipleValidate::class, new FieldSelectMultipleValidate());
	}

	public function testInvalidArgument(): void
	{
		$M = new FieldSelectMultipleValidate();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . FieldSelectMultipleElement::class);

		$M(new Fields(), new FieldTextElement());
	}
}

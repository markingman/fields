<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\FieldSelectElement;
use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class FieldSelectValidateTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(FieldSelectValidate::class, new FieldSelectValidate());
	}

	public function testInvalidArgument(): void
	{
		$M = new FieldSelectValidate();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . FieldSelectElement::class);

		$M(new Fields(), new FieldTextElement());
	}
}

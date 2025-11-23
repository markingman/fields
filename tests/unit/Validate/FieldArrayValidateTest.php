<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\FieldArrayElement;
use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class FieldArrayValidateTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(FieldArrayValidate::class, new FieldArrayValidate());
	}

	public function testInvalidArgument(): void
	{
		$M = new FieldArrayValidate();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . FieldArrayElement::class);

		$M(new Fields(), new FieldTextElement());
	}
}

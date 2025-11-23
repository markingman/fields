<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\FieldBoolElement;
use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class FieldBoolValidateTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(FieldBoolValidate::class, new FieldBoolValidate());
	}

	public function testInvalidArgument(): void
	{
		$M = new FieldBoolValidate();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . FieldBoolElement::class);

		$M(new Fields(), new FieldTextElement());
	}
}

<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\FieldEmailElement;
use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class FieldEmailValidateTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(FieldEmailValidate::class, new FieldEmailValidate());
	}

	public function testInvalidArgument(): void
	{
		$M = new FieldEmailValidate();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . FieldEmailElement::class);

		$M(new Fields(), new FieldTextElement());
	}
}

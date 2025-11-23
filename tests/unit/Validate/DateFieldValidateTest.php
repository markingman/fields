<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\DateFieldElement;
use MarkIngman\Fields\Element\TextFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class DateFieldValidateTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(DateFieldValidate::class, new DateFieldValidate());
	}

	public function testInvalidArgument(): void
	{
		$M = new DateFieldValidate();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . DateFieldElement::class);

		$M(new Fields(), new TextFieldElement());
	}
}

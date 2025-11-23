<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\BoolFieldElement;
use MarkIngman\Fields\Element\TextFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class BoolFieldValidateTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(BoolFieldValidate::class, new BoolFieldValidate());
	}

	public function testInvalidArgument(): void
	{
		$M = new BoolFieldValidate();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . BoolFieldElement::class);

		$M(new Fields(), new TextFieldElement());
	}
}

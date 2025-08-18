<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Validate\ValidateFieldBool;
use PHPUnit\Framework\TestCase;

final class ValidateFieldBoolTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(ValidateFieldBool::class, new ValidateFieldBool());
	}

	public function testInvalidArgument(): void
	{
		$M = new ValidateFieldBool();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected FieldBoolElement');

		$M(new Fields(), new FieldTextElement());
	}
}

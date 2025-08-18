<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
use MarkIngman\Fields\Element\FieldArrayElement;
use MarkIngman\Fields\Validate\ValidateFieldText;
use PHPUnit\Framework\TestCase;

final class ValidateFieldTextTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(ValidateFieldText::class, new ValidateFieldText());
	}

	public function testInvalidArgument(): void
	{
		$M = new ValidateFieldText();

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Expected FieldTextElement');

		$M(new Fields(), new FieldArrayElement());
	}
}

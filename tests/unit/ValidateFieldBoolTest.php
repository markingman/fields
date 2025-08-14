<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
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

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Expected FieldBoolElement');

		$M(new Fields(), new FieldTextElement());
	}
}

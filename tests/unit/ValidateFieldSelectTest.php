<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class ValidateFieldSelectTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(ValidateFieldSelect::class, new ValidateFieldSelect());
	}

	public function testInvalidArgument(): void
	{
		$M = new ValidateFieldSelect();

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Expected FieldSelectElement');

		$M(new Fields(), new FieldTextElement());
	}
}

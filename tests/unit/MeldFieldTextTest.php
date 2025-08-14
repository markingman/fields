<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class MeldFieldTextTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(MeldFieldText::class, new MeldFieldText());
	}

	public function testInvalidArgument(): void
	{
		$M = new MeldFieldText();

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Expected FieldTextElement');

		$M(new Fields(), new FieldArrayElement(), null);
	}
}

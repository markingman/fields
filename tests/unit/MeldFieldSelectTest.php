<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class MeldFieldSelectTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(MeldFieldSelect::class, new MeldFieldSelect());
	}

	public function testInvalidArgument(): void
	{
		$M = new MeldFieldSelect();

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Expected FieldSelectElement');

		$M(new Fields(), new FieldTextElement(), null);
	}
}

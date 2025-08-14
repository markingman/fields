<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class MeldFieldEmailTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(MeldFieldEmail::class, new MeldFieldEmail());
	}

	public function testInvalidArgument(): void
	{
		$M = new MeldFieldEmail();

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Expected FieldEmailElement');

		$M(new Fields(), new FieldTextElement(), null);
	}
}

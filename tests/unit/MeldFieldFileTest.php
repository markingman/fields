<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class MeldFieldFileTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(MeldFieldFile::class, new MeldFieldFile());
	}

	public function testInvalidArgument(): void
	{
		$M = new MeldFieldFile();

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Expected FieldFileElement');

		$M(new Fields(), new FieldTextElement(), null);
	}
}

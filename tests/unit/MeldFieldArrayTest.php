<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class MeldFieldArrayTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(MeldFieldArray::class, new MeldFieldArray());
	}

	public function testInvalidArgument(): void
	{
		$M = new MeldFieldArray();

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Expected FieldArrayElement');

		$M(new Fields(), new FieldTextElement(), null);
	}

	public function testIgnoreDisabled(): void
	{
		$E = new FieldArrayElement(disabled: true);

		$M = $E->get_meld();
		$M(new Fields(), $E, ['a', 'b']);

		$this->assertEquals([], $E->value);
	}
}

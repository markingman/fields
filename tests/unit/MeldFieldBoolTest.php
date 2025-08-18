<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class MeldFieldBoolTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(MeldFieldBool::class, new MeldFieldBool());
	}

	public function testInvalidArgument(): void
	{
		$M = new MeldFieldBool();

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Expected FieldBoolElement');

		$M(new Fields(), new FieldTextElement(), null);
	}

	public function testIgnoreDisabled(): void
	{
		$E = new FieldBoolElement(disabled: true);

		$M = $E->get_meld();
		$M(new Fields(), $E, 'yes');

		$this->assertEquals('', $E->value);
	}
}

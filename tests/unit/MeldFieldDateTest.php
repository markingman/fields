<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
use MarkIngman\Fields\Element\FieldDateElement;
use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Meld\MeldFieldDate;
use PHPUnit\Framework\TestCase;

final class MeldFieldDateTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(MeldFieldDate::class, new MeldFieldDate());
	}

	public function testInvalidArgument(): void
	{
		$M = new MeldFieldDate();

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Expected FieldDateElement');

		$M(new Fields(), new FieldTextElement(), null);
	}

	public function testIgnoreDisabled(): void
	{
		$E = new FieldDateElement(disabled: true);

		$M = $E->get_meld();
		$M(new Fields(), $E, '2000-01-01');

		$this->assertEquals('', $E->value);
	}
}

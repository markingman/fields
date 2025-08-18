<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use MarkIngman\Fields\Element\FieldSelectElement;
use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Meld\MeldFieldSelect;
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

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected FieldSelectElement');

		$M(new Fields(), new FieldTextElement(), null);
	}

	public function testIgnoreDisabled(): void
	{
		$E = new FieldSelectElement(disabled: true, options: ['' => '', 'a' => 'A', 'b' => 'B']);

		$M = $E->get_meld();
		$M(new Fields(), $E, ['a', 'b']);

		$this->assertEquals('', $E->value);
	}
}

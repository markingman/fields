<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
use MarkIngman\Fields\Element\FieldArrayElement;
use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Meld\MeldFieldText;
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

	public function testIgnoreDisabled(): void
	{
		$E = new FieldTextElement(disabled: true);

		$M = $E->get_meld();
		$M(new Fields(), $E, 'test');

		$this->assertEquals('', $E->value);
	}
}

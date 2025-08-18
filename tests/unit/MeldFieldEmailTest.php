<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use MarkIngman\Fields\Element\FieldEmailElement;
use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Meld\MeldFieldEmail;
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

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected FieldEmailElement');

		$M(new Fields(), new FieldTextElement(), null);
	}

	public function testIgnoreDisabled(): void
	{
		$E = new FieldEmailElement(disabled: true);

		$M = $E->get_meld();
		$M(new Fields(), $E, 'test@example.com');

		$this->assertEquals('', $E->value);
	}
}

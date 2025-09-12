<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class ValidateFieldSelectTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(ValidateFieldSelect::class, new ValidateFieldSelect());
	}

	public function testInvalidArgument(): void
	{
		$M = new ValidateFieldSelect();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected FieldSelectElement');

		$M(new Fields(), new FieldTextElement());
	}
}

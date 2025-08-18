<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Validate\ValidateFieldEmail;
use PHPUnit\Framework\TestCase;

final class ValidateFieldEmailTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(ValidateFieldEmail::class, new ValidateFieldEmail());
	}

	public function testInvalidArgument(): void
	{
		$M = new ValidateFieldEmail();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected FieldEmailElement');

		$M(new Fields(), new FieldTextElement());
	}
}

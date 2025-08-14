<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
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

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Expected FieldEmailElement');

		$M(new Fields(), new FieldTextElement());
	}
}

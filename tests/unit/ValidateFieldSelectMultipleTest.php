<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Validate\ValidateFieldSelectMultiple;
use PHPUnit\Framework\TestCase;

final class ValidateFieldSelectMultipleTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(ValidateFieldSelectMultiple::class, new ValidateFieldSelectMultiple());
	}

	public function testInvalidArgument(): void
	{
		$M = new ValidateFieldSelectMultiple();

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Expected FieldSelectMultipleElement');

		$M(new Fields(), new FieldTextElement());
	}
}

<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class MeldFieldSelectMultipleTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(MeldFieldSelectMultiple::class, new MeldFieldSelectMultiple());
	}

	public function testInvalidArgument(): void
	{
		$M = new MeldFieldSelectMultiple();

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Expected FieldSelectMultipleElement');

		$M(new Fields(), new FieldTextElement(), null);
	}

	public function testSelectAllOption(): void
	{
		$E = new FieldSelectMultipleElement(
			value: [''], 
			options: ['' => '', 'all' => 'All', 'a' => 'A', 'b' => 'B', 'c' => 'C'],
			null_values: [''],
			all_value: 'all',
		);

		$M = $E->get_meld();
		$M(new Fields(), $E, ['a', 'b', 'all']);

		$this->assertEquals(['all'], $E->value);
	}

	public function testSelectNullValue(): void
	{
		$E = new FieldSelectMultipleElement(
			value: ['all'], 
			options: ['' => '', 'all' => 'All', 'a' => 'A', 'b' => 'B', 'c' => 'C'],
			null_values: [''],
			all_value: 'all',
		);

		$E->value = [];

		$M = $E->get_meld();
		$M(new Fields(), $E, ['x', 'y', 'z']);

		$this->assertEquals([''], $E->value);
	}

	public function testIgnoreDisabled(): void
	{
		$E = new FieldSelectMultipleElement(disabled: true, options: ['a' => 'A', 'b' => 'B']);

		$M = $E->get_meld();
		$M(new Fields(), $E, ['a', 'b']);

		$this->assertEquals([], $E->value);
	}
}

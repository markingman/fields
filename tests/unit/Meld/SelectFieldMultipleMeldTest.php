<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use MarkIngman\Fields\Element\SelectFieldMultipleElement;
use MarkIngman\Fields\Element\TextFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class SelectFieldMultipleMeldTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(SelectFieldMultipleMeld::class, new SelectFieldMultipleMeld());
	}

	public function testInvalidArgument(): void
	{
		$M = new SelectFieldMultipleMeld();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . SelectFieldMultipleElement::class);

		$M(new Fields(), new TextFieldElement(), null);
	}

	public function testSelectAllOption(): void
	{
		$E = new SelectFieldMultipleElement(
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
		$E = new SelectFieldMultipleElement(
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

	public function testSelectNullMixValues(): void
	{
		$E = new SelectFieldMultipleElement(
			value: ['all'],
			options: ['' => '', 'all' => 'All', 'a' => 'A', 'b' => 'B', 'c' => 'C'],
			null_values: [''],
			all_value: 'all',
		);

		$E->value = [];

		$M = $E->get_meld();
		$M(new Fields(), $E, ['a', '', 'z', 'b']);

		$this->assertEquals(['a', 'b'], $E->value);
	}

	public function testIgnoreDisabled(): void
	{
		$E = new SelectFieldMultipleElement(disabled: true, options: ['a' => 'A', 'b' => 'B']);

		$M = $E->get_meld();
		$M(new Fields(), $E, ['a', 'b']);

		$this->assertEquals([], $E->value);
	}
}

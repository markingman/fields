<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use MarkIngman\Fields\Element\SelectMultipleFieldElement;
use MarkIngman\Fields\Element\TextFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class SelectMultipleFieldMeldTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(SelectMultipleFieldMeld::class, new SelectMultipleFieldMeld());
	}

	public function testInvalidArgument(): void
	{
		$M = new SelectMultipleFieldMeld();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . SelectMultipleFieldElement::class);

		$M(new Fields(), new TextFieldElement(), null);
	}

	public function testSelectAllOption(): void
	{
		$E = new SelectMultipleFieldElement(
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
		$E = new SelectMultipleFieldElement(
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
		$E = new SelectMultipleFieldElement(
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
		$E = new SelectMultipleFieldElement(disabled: true, options: ['a' => 'A', 'b' => 'B']);

		$M = $E->get_meld();
		$M(new Fields(), $E, ['a', 'b']);

		$this->assertEquals([], $E->value);
	}
}

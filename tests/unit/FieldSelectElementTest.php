<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
use MarkIngman\Fields\Element\FieldSelectElement;
use PHPUnit\Framework\TestCase;

final class FieldSelectElementTest extends TestCase
{
	public function testFieldSelect(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public FieldSelectElement $sel = new FieldSelectElement(
					value: 'a',
					options: ['a' => 'A', 'b' => 'B']
				)
			) {
			}
		};

		$F->meld_values(['sel' => 'b']);
		$this->assertSame(['sel' => 'b'], $F->get_values());

		$this->assertSame('A', $F->sel->get_label('a'));
		$this->assertSame('B', $F->sel->get_selected_label());
	}

	public function testInvalidValueArgument(): void
	{
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Value must be an option');

		new FieldSelectElement(value: 'x', options: ['a' => 'A', 'b' => 'B']);
	}

	public function testInvalidNullValueArgument(): void
	{
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Null values must be options');

		new FieldSelectElement(value: 'a', options: ['a' => 'A', 'b' => 'B'], null_values: ['']);
	}

	public function testMeld(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public FieldSelectElement $sel = new FieldSelectElement(
					required: true,
					value: 'a',
					options: ['a' => 'A', 'b' => 'B'],
				)
			) {
			}
		};

		$this->assertSame(['sel' => 'a'], $F->get_values());

		$F->meld_values(['sel' => 'd']);
		$this->assertSame(['sel' => 'a'], $F->get_values());

		$F->meld_values(['sel' => 'b']);
		$this->assertSame(['sel' => 'b'], $F->get_values());
	}

	public function testValidation(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public FieldSelectElement $sel = new FieldSelectElement(
					required: true,
					value: '',
					options: ['' => '', 'a' => 'A', 'b' => 'B'],
					null_values: [''],
				)
			) {
			}
		};

		$this->assertFalse($F->validate());
		$this->assertEquals(FieldErrType::ERR_EMPTY, $F->sel->err);
		$this->assertFalse($F->sel->valid);

		$F->sel->value = 'x';
		$this->assertFalse($F->validate());
		$this->assertEquals(FieldErrType::ERR_FORMAT, $F->sel->err);
		$this->assertFalse($F->sel->valid);

		$F->sel->value = 'b';
		$this->assertTrue($F->validate());
		$this->assertEquals(FieldErrType::ERR_NONE, $F->sel->err);
		$this->assertTrue($F->sel->valid);
	}
}

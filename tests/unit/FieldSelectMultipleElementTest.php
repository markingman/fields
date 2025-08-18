<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class FieldSelectMultipleElementTest extends TestCase
{
	public function testFieldSelectMultiple(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public FieldSelectMultipleElement $sel = new FieldSelectMultipleElement(
					value: ['a'],
					options: ['a' => 'A', 'b' => 'B', 'c' => 'C']
				)
			) {
			}
		};

		$F->meld_values(['sel' => ['b']]);
		$this->assertSame(['sel' => ['a', 'b']], $F->get_values());

		$this->assertSame(['A'], $F->sel->get_labels(['a']));
		$this->assertSame(['A', 'B'], $F->sel->get_selected_labels());

		$F->meld_values(['sel' => ['b', 'a', 'c']]);
		$this->assertSame(['A', 'B', 'C'], $F->sel->get_selected_labels());
	}

 	public function testInvalidValueArgument(): void
	{
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Values must be options');

		new FieldSelectMultipleElement(value: ['x'], options: ['a' => 'A', 'b' => 'B']);
	}

 	public function testInvalidNullValueArgument(): void
	{
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Null values must be options');

		new FieldSelectMultipleElement(value: ['a'], options: ['a' => 'A', 'b' => 'B'], null_values: ['']);
	}

 	public function testInvalidAllValueArgument(): void
	{
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('All-value must be an option');

		new FieldSelectMultipleElement(value: ['a'], options: ['a' => 'A', 'b' => 'B'], all_value: 'ALL');
	}

	public function testMeld(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public FieldSelectMultipleElement $sel = new FieldSelectMultipleElement(
					required: true,
					value: [],
					options: ['a' => 'A', 'b' => 'B'],
				)
			) {
			}
		};

		$this->assertSame(['sel' => []], $F->get_values());

		$F->meld_values(['sel' => ['d']]);
		$this->assertSame(['sel' => []], $F->get_values());

		$F->meld_values(['sel' => ['a']]);
		$this->assertSame(['sel' => ['a']], $F->get_values());

		$F->meld_values(['sel' => ['b', 'a']]);
		$this->assertSame(['sel' => ['a', 'b']], $F->get_values());
	}

	public function testValidation(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public FieldSelectMultipleElement $sel = new FieldSelectMultipleElement(
					required: true,
					value: [],
					options: ['a' => 'A', 'b' => 'B'],
				)
			) {
			}
		};

		$this->assertFalse($F->validate());
		$this->assertEquals(FieldErrType::ERR_EMPTY, $F->sel->err);
		$this->assertFalse($F->sel->valid);

		$F->sel->value = ['x'];
		$this->assertFalse($F->validate());
		$this->assertEquals(FieldErrType::ERR_FORMAT, $F->sel->err);
		$this->assertFalse($F->sel->valid);

		$F->sel->value = ['b'];
		$this->assertTrue($F->validate());
		$this->assertEquals(FieldErrType::ERR_NONE, $F->sel->err);
		$this->assertTrue($F->sel->valid);
	}
}

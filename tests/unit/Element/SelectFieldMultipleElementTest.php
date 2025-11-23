<?php declare(strict_types=1);

namespace MarkIngman\Fields\Element;

use InvalidArgumentException;
use MarkIngman\Fields\Element\SelectFieldMultipleElement;
use MarkIngman\Fields\Exception\ConfigurationException;
use PHPUnit\Framework\TestCase;
use MarkIngman\Fields\Fields;
use MarkIngman\Fields\FieldErrType;

final class SelectFieldMultipleElementTest extends TestCase
{
	public function testSelectFieldMultiple(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public SelectFieldMultipleElement $sel = new SelectFieldMultipleElement(
					value: ['a'],
					options: ['a' => 'A', 'b' => 'B', 'c' => 'C']
				)
			) {
			}
		};

		$F->meld_values(['sel' => ['b']]);
		$this->assertSame(['sel' => ['a', 'b']], $F->get_values());

		$this->assertTrue($F->sel->selected('a'));
		$this->assertTrue($F->sel->selected('b'));
		$this->assertFalse($F->sel->selected('c'));

		$this->assertSame(['A'], $F->sel->get_labels(['a']));
		$this->assertSame(['A', 'B'], $F->sel->get_selected_labels());

		$F->meld_values(['sel' => ['b', 'a', 'c']]);
		$this->assertSame(['A', 'B', 'C'], $F->sel->get_selected_labels());
	}

	public function testInvalidValueArgument(): void
	{
		$this->expectException(ConfigurationException::class);
		$this->expectExceptionMessage('Values must be options');

		new SelectFieldMultipleElement(value: ['x'], options: ['a' => 'A', 'b' => 'B']);
	}

	public function testInvalidNullValueArgument(): void
	{
		$this->expectException(ConfigurationException::class);
		$this->expectExceptionMessage('Null values must be options');

		new SelectFieldMultipleElement(value: ['a'], options: ['a' => 'A', 'b' => 'B'], null_values: ['']);
	}

	public function testInvalidAllValueArgument(): void
	{
		$this->expectException(ConfigurationException::class);
		$this->expectExceptionMessage('All-value must be an option');

		new SelectFieldMultipleElement(value: ['a'], options: ['a' => 'A', 'b' => 'B'], all_value: 'ALL');
	}

	public function testMeld(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public SelectFieldMultipleElement $sel = new SelectFieldMultipleElement(
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
				public SelectFieldMultipleElement $sel = new SelectFieldMultipleElement(
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

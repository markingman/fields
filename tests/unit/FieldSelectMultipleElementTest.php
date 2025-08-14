<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use PHPUnit\Framework\TestCase;

final class FieldSelectMultipleElementTest extends TestCase
{
	public function testFieldSelect(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public FieldSelectMultipleElement $sel = new FieldSelectMultipleElement(
					value: ['a'],
					options: ['a' => 'A', 'b' => 'B']
				)
			) {
			}
		};

		$F->meld_values(['sel' => ['b']]);
		$this->assertSame(['sel' => ['b']], $F->get_values());

		$this->assertSame(['A'], $F->sel->get_labels(['a']));
		$this->assertSame(['B'], $F->sel->get_selected_labels());

		$F->meld_values(['sel' => ['b', 'a']]);
		$this->assertSame(['A', 'B'], $F->sel->get_selected_labels());
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
					value: [''],
					options: ['a' => 'A', 'b' => 'B'],
					required: true,
				)
			) {
			}
		};

		$this->assertFalse($F->validate());
		$this->assertEquals($F->sel->err, FieldErrType::ERR_EMPTY);
		$this->assertFalse($F->sel->valid);

		$F->sel->value = ['x'];
		$this->assertFalse($F->validate());
		$this->assertEquals($F->sel->err, FieldErrType::ERR_FORMAT);
		$this->assertFalse($F->sel->valid);

		$F->sel->value = ['b'];
		$this->assertTrue($F->validate());
		$this->assertEquals($F->sel->err, FieldErrType::ERR_NONE);
		$this->assertTrue($F->sel->valid);
	}
}

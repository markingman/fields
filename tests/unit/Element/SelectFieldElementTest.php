<?php declare(strict_types=1);

namespace MarkIngman\Fields\Element;

use InvalidArgumentException;
use MarkIngman\Fields\Element\SelectFieldElement;
use MarkIngman\Fields\Exception\ConfigurationException;
use PHPUnit\Framework\TestCase;
use MarkIngman\Fields\Fields;
use MarkIngman\Fields\FieldErrType;

final class SelectFieldElementTest extends TestCase
{
	public function testSelectField(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public SelectFieldElement $sel = new SelectFieldElement(
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
		$this->expectException(ConfigurationException::class);
		$this->expectExceptionMessage('Value must be an option');

		new SelectFieldElement(value: 'x', options: ['a' => 'A', 'b' => 'B']);
	}

	public function testInvalidNullValueArgument(): void
	{
		$this->expectException(ConfigurationException::class);
		$this->expectExceptionMessage('Null values must be options');

		new SelectFieldElement(value: 'a', options: ['a' => 'A', 'b' => 'B'], null_values: ['']);
	}

	public function testMeld(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public SelectFieldElement $sel = new SelectFieldElement(
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
				public SelectFieldElement $sel = new SelectFieldElement(
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

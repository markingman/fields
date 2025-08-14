<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use PHPUnit\Framework\TestCase;

final class FieldDateElementTest extends TestCase
{
	public function testDateField(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public FieldDateElement $date = new FieldDateElement()
			) {
			}
		};

		$F->meld_values(['date' => '1970-01-01']);
		$this->assertEquals(['date' => '1970-01-01'], $F->get_values());
	}

	public function testMeld(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public FieldDateElement $date = new FieldDateElement()
			) {
			}
		};

		$F->meld_values(['date' => ['from' => '1970-01-01']]);
		$this->assertEquals(['date' => ''], $F->get_values());

		$F->meld_values(['date' => '   1970-01-01   ']);
		$this->assertEquals(['date' => '1970-01-01'], $F->get_values());

		$F->meld_values(['date' => '1970-01-01xxx']);
		$this->assertEquals(['date' => ''], $F->get_values());

		$F->meld_values(['date' => '1970/01/01']);
		$this->assertEquals(['date' => ''], $F->get_values());
	}

	public function testValidation(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public FieldDateElement $date = new FieldDateElement()
			) {
			}
		};

		$F->date->value = '';

		$F->date->required = true;
		$this->assertFalse($F->validate());
		$this->assertEquals(false, $F->date->valid);
		$this->assertEquals(FieldErrType::ERR_EMPTY, $F->date->err);

		$F->date->required = false;
		$this->assertTrue($F->validate());
		$this->assertEquals($F->date->valid, true);
		$this->assertEquals(FieldErrType::ERR_NONE, $F->date->err);

		$F->date->value = '1970-02-31';
		$this->assertFalse($F->validate());
		$this->assertEquals(false, $F->date->valid);
		$this->assertEquals(FieldErrType::ERR_FORMAT, $F->date->err);

		$F->date->value = '1970-02-28';
		$this->assertTrue($F->validate());
		$this->assertEquals(true, $F->date->valid);
		$this->assertEquals(FieldErrType::ERR_NONE, $F->date->err);
	}
}

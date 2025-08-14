<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use PHPUnit\Framework\TestCase;

final class FieldBoolElementTest extends TestCase
{
	public function testFieldBool(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public FieldBoolElement $flag = new FieldBoolElement(option: 'on')
			) {
			}
		};

		$F->meld_values(['flag' => 'off']);
		$this->assertSame(['flag' => ''], $F->get_values());
		$this->assertFalse($F->flag->checked());

		$F->meld_values(['flag' => 'on']);
		$this->assertSame(['flag' => 'on'], $F->get_values());
		$this->assertTrue($F->flag->checked());
	}

	public function testMeldNull(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public FieldBoolElement $flag = new FieldBoolElement(value: 'on', option: 'on', option_empty: 'off')
			) {
			}
		};

		$F->meld_values(['flag' => 'off']);
		$this->assertSame(['flag' => $F->flag->option_empty], $F->get_values());
		$this->assertFalse($F->flag->checked());

		$F->meld_values(['flag' => null]);// defaults to '' empty string
		$this->assertSame(['flag' => $F->flag->option], $F->get_values());
		$this->assertTrue($F->flag->checked());

		$F->meld_values(['flag' => 'on']);
		$this->assertSame(['flag' => 'on'], $F->get_values());
		$this->assertTrue($F->flag->checked());
	}

	public function testValidation(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public FieldBoolElement $flag = new FieldBoolElement(required: true)
			) {
			}
		};

		$this->assertFalse($F->validate());
		$this->assertEquals($F->flag->err, FieldErrType::ERR_EMPTY);
		$this->assertFalse($F->flag->valid);

		$F->flag->value = 'x';
		$this->assertFalse($F->validate());
		$this->assertEquals($F->flag->err, FieldErrType::ERR_FORMAT);
		$this->assertFalse($F->flag->valid);

		$F->meld_values(['flag' => 'yes']);
		$this->assertTrue($F->validate());
		$this->assertEquals($F->flag->err, FieldErrType::ERR_NONE);
		$this->assertTrue($F->flag->valid);
	}
}

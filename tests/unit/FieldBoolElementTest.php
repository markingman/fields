<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
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

		$F->meld_values(['flag' => '']);
		$F->update_default_values();
		$F->meld_values(['flag' => 'on']);
		$F->reset_values();
		$this->assertSame(['flag' => ''], $F->get_values());
	}

	public function testInvalidValueArgument(): void
	{
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Value not in options');

		new FieldBoolElement(value: 'x', option: 'yes', option_empty: 'no');
	}

	public function testInvalidOptionsArguments(): void
	{
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Options must be different');

		new FieldBoolElement(value: 'yes', option: 'yes', option_empty: 'yes');
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
		$this->assertEquals(FieldErrType::ERR_EMPTY, $F->flag->err);
		$this->assertFalse($F->flag->valid);

		$F->flag->value = 'x';
		$this->assertFalse($F->validate());
		$this->assertEquals(FieldErrType::ERR_FORMAT, $F->flag->err);
		$this->assertFalse($F->flag->valid);

		$F->meld_values(['flag' => 'yes']);
		$this->assertTrue($F->validate());
		$this->assertEquals(FieldErrType::ERR_NONE, $F->flag->err);
		$this->assertTrue($F->flag->valid);
	}
}

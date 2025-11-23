<?php declare(strict_types=1);

namespace MarkIngman\Fields\Element;

use MarkIngman\Fields\FieldErrType;
use MarkIngman\Fields\Fields;
use MarkIngman\Fields\TestEmailElementFields;
use PHPUnit\Framework\TestCase;

final class FieldEmailElementTest extends TestCase
{
	public function testEmailField(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public FieldEmailElement $email = new FieldEmailElement()
			) {
			}
		};

		$this->assertEquals(['email' => ''], $F->get_values());
		$F->meld_values(['email' => 'test@example.com']);
		$this->assertEquals(['email' => 'test@example.com'], $F->get_values());
	}

	public function testMeldIgnoreOutOfRangeValues(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public FieldEmailElement $email = new FieldEmailElement(max_len: 8)
			) {
			}
		};

		$this->assertEquals(['email' => ''], $F->get_values());
		$F->meld_values(['email' => '123456789']);
		$this->assertEquals(['email' => ''], $F->get_values());

		$F->meld_values(['email' => '12345678']);
		$this->assertEquals(['email' => '12345678'], $F->get_values());

		$F->meld_values(['email' => ['12345678']]);
		$this->assertEquals(['email' => ''], $F->get_values());
	}

	public function testValidateEmailFormat(): void
	{
		$F = new TestEmailElementFields(required: true);

		$this->assertFalse($F->validate());
		$F->email->valid = false;
		$F->email->err = FieldErrType::ERR_EMPTY;

		$F->email->required = false;
		$this->assertTrue($F->validate());
		$this->assertTrue($F->email->valid);
		$this->assertEquals(FieldErrType::ERR_NONE, $F->email->err);

		$F = new TestEmailElementFields(min_len: 5, max_len: 8, required: true);

		$F->email->value = 'a@b';
		$this->assertFalse($F->validate());
		$this->assertFalse($F->email->valid);
		$this->assertEquals(FieldErrType::ERR_FORMAT, $F->email->err);

		$F->email->value = 'test@example.com';
		$this->assertFalse($F->validate());
		$this->assertFalse($F->email->valid);
		$this->assertEquals(FieldErrType::ERR_FORMAT, $F->email->err);

		$F = new TestEmailElementFields(max_len: 200);
		$F->email->value = 'test@example.com';
		$this->assertTrue($F->validate());
		$this->assertTrue($F->email->valid);
		$this->assertEquals(FieldErrType::ERR_NONE, $F->email->err);

		$F->email->value = 'test@@example.com';
		$this->assertFalse($F->validate());
		$this->assertFalse($F->email->valid);
		$this->assertEquals(FieldErrType::ERR_FORMAT, $F->email->err);
	}
}

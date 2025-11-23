<?php declare(strict_types=1);

namespace MarkIngman\Fields\Element;

use MarkIngman\Fields\FieldErrType;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class TextFieldElementTest extends TestCase
{
	public function testTextField(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public TextFieldElement $text = new TextFieldElement()
			) {
			}
		};

		$this->assertEquals(['text' => ''], $F->get_values());
		$F->meld_values(['text' => 'abc']);
		$this->assertEquals(['text' => 'abc'], $F->get_values());
	}

	public function testMeldIgnoreOutOfRangeValues(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public TextFieldElement $text = new TextFieldElement(max_len: 8)
			) {
			}
		};

		$this->assertEquals(['text' => ''], $F->get_values());
		$F->meld_values(['text' => '123456789']);
		$this->assertEquals(['text' => ''], $F->get_values());

		$F->meld_values(['text' => '12345678']);
		$this->assertEquals(['text' => '12345678'], $F->get_values());

		$F->meld_values(['text' => ['12345678']]);
		$this->assertEquals(['text' => ''], $F->get_values());
	}

	public function testValidateTextFormat(): void
	{
		$get_fields = function (?int $min_len = null, ?int $max_len = null, ?bool $required = null): Fields {
			return new class($min_len, $max_len, $required) extends Fields {
				public TextFieldElement $text;

				public function __construct(?int $min_len = null, ?int $max_len = null, ?bool $required = null)
				{
					$this->text = new TextFieldElement(
						required: $required ?? true,
						max_len: $max_len ?? 200,
						min_len: $min_len ?? 3,
					);
				}
			};
		};

		$F = $get_fields(required: true);

		$this->assertFalse($F->validate());
		$this->assertFalse($F->text->valid);
		$this->assertEquals(FieldErrType::ERR_EMPTY, $F->text->err);

		$F->text->required = false;
		$this->assertTrue($F->validate());
		$this->assertTrue($F->text->valid);
		$this->assertEquals(FieldErrType::ERR_NONE, $F->text->err);

		$F = $get_fields(min_len: 5, max_len: 8, required: true);

		$F->text->value = '1234';
		$this->assertFalse($F->validate());
		$this->assertFalse($F->text->valid);
		$this->assertEquals(FieldErrType::ERR_FORMAT, $F->text->err);

		$F->text->value = '123456789';
		$this->assertFalse($F->validate());
		$this->assertFalse($F->text->valid);
		$this->assertEquals(FieldErrType::ERR_FORMAT, $F->text->err);

		$F = $get_fields(max_len: 200);
		$F->text->value = '123456789';
		$this->assertTrue($F->validate());
		$this->assertTrue($F->text->valid);
		$this->assertEquals(FieldErrType::ERR_NONE, $F->text->err);
	}
}


<?php declare(strict_types=1);

namespace MarkIngman\Fields\Element;

use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;

final class ArrayFieldElementTest extends TestCase
{
	public function testArrayField(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public ArrayFieldElement $tags = new ArrayFieldElement()
			) {
			}
		};

		$F->meld_values(['tags' => ['a', 'b', 'c']]);
		$this->assertSame(['tags' => ['a', 'b', 'c']], $F->get_values());

		$F->reset_values();
		$this->assertSame(['tags' => []], $F->get_values());

		$F->meld_values(['tags' => ['a', 'b', 'c']]);
		$this->assertSame(['tags' => ['a', 'b', 'c']], $F->get_values());

		$F->update_default_values();
		$this->assertSame(['tags' => ['a', 'b', 'c']], $F->get_values());

		$F->meld_values(['tags' => ['d']]);
		$this->assertSame(['tags' => ['a', 'b', 'c', 'd']], $F->get_values());

		$F->reset_values();
		$this->assertSame(['tags' => ['a', 'b', 'c']], $F->get_values());
	}

	public function testMeldIgnoreOutOfRange(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public ArrayFieldElement $tags = new ArrayFieldElement(
					max_count: 3,
				)
			) {
			}
		};

		$F->meld_values(['tags' => ['a', 'b', 'c', 'd']]);
		$this->assertSame([], $F->get_values()['tags']);
	}

	public function testMeldTrimsFiltersAndResets(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public ArrayFieldElement $tags = new ArrayFieldElement(
					name: 'tags',
					max_count: 5,
					max_len: 5,
					min_len: 2,
				)
			) {
			}
		};

		$F->meld_values(['tags' => ['  a  ', ['z'], 'xx', 'toolong', ' ok ']]);
		$this->assertSame(['xx', 'ok'], $F->get_values()['tags'], 'Ignore too short, too long and not string values; trim other values');

		$F->meld_values(['tags' => ['new']]);
		$this->assertSame(['new'], $F->get_values()['tags']);
	}

	public function testValidation(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public ArrayFieldElement $tags = new ArrayFieldElement(
					required: true,
					max_count: 2,
					max_len: 3,
					min_len: 2,
				)
			) {
			}
		};

		$this->assertFalse($F->validate()); // empty array, required => ERR_EMPTY

		$F->tags->required = false;

		$this->assertTrue($F->validate());

		$F->meld_values(['tags' => ['xx', 'xx2', 'xx3']]);
		$this->assertEquals(['tags' => []], $F->get_values());
		$this->assertTrue($F->validate());

		$F->meld_values(['tags' => ['ok']]);
		$this->assertTrue($F->validate());

		$F->meld_values(['tags' => ['ok', 'ok2']]);
		$this->assertTrue($F->validate());

		$F->meld_values(['tags' => ['ok', 'ok2', 'ok3']]);
		$this->assertTrue($F->validate());

		$F->tags->value = ['x'];
		$this->assertFalse($F->validate());

		$F->tags->value = ['xxxx'];
		$this->assertFalse($F->validate());

		$F->tags->value = ['ok', 'x'];
		$this->assertFalse($F->validate());

		$F->tags->value = ['xxxx', 'ok'];
		$this->assertFalse($F->validate());

		$F->tags->value = ['xx', 'xx2', 'xx3', 'xx4'];
		$this->assertFalse($F->validate());
	}
}

<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use PHPUnit\Framework\TestCase;

final class FieldsTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(FieldsInterface::class, new Fields());
	}

	public function testMeldIgnoreUnknownValues(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public FieldTextElement $text = new FieldTextElement()
			) {
			}
		};

		$this->assertSame(['text' => ''], $F->get_values());
		$F->meld_values(['unknown' => 'x', 'TEXT' => 'x', 'Text' => 'x', 'text:' => 'x']);
		$this->assertSame(['text' => ''], $F->get_values());
	}

	public function testResetValues(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public FieldTextElement $text = new FieldTextElement(value: 'test')
			) {
			}
		};

		$this->assertEquals(['text' => 'test'], $F->get_values());
		$F->text->value = '123';
		$this->assertEquals(['text' => '123'], $F->get_values());
		$F->reset_values();
		$this->assertEquals(['text' => 'test'], $F->get_values());
	}

	public function testValidateAndGetInvalids(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public FieldTextElement $text = new FieldTextElement(max_len: 2)
			) {
			}
		};

		$F->text->value = '123';
		$this->assertFalse($F->validate());
		$this->assertFalse($F->is_valid());
		$this->assertEquals(['text'], $F->get_invalids());
	}

	public function testGetPropertyName(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public FieldTextElement $text = new FieldTextElement()
			) {
			}
		};

		$this->assertEquals('text', $F->get_property_name($F->text));
	}

	public function testAlternateNameAlias(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public FieldArrayElement $tags = new FieldArrayElement(
					name: 't',
				)
			) {
			}
		};

		$F->meld_values(['t' => ['a']]);
		$this->assertSame('t', $F->get_last_meld_key($F->tags));
		$this->assertSame(['a'], $F->get_values()['tags']);

//         $this->assertSame('tags', $F->get_property_name($F->tags));

		$F->meld_values(['tags' => ['b']]);
		$this->assertSame('tags', $F->get_last_meld_key($F->tags));
		$this->assertSame(['b'], $F->get_values()['tags']);
	}

	public function testEntityNewFields(): void
	{
		$EntityFields = new TestEntityFields();

		$this->assertEquals(['email' => ''], $EntityFields->get_values());
		$this->assertEquals(new TestExampleEntity, $EntityFields->get_entity());

		$EntityFields->meld_values(['email' => '@test']);

		$this->assertFalse($EntityFields->validate());

		$EntityFields->meld_values(['email' => 'test@example.com']);

		$this->assertTrue($EntityFields->validate());

		$this->assertEquals(['email' => 'test@example.com'], $EntityFields->get_values());
		$this->assertEquals(new TestExampleEntity(
			email: 'test@example.com'), $EntityFields->get_entity());
	}

	public function testEntityEditFields(): void
	{
		$EntityFields = new TestEntityFields();
		$ExampleEntity = new TestExampleEntity(email: 'test@example.com');

		$EntityFields->meld_entity($ExampleEntity);
		$this->assertEquals($ExampleEntity, $EntityFields->get_entity());

		$EntityFields->meld_values(['email' => 'update@example.com']);
		$this->assertTrue($EntityFields->validate());

		$this->assertEquals(['email' => 'update@example.com'], $EntityFields->get_values());
		$this->assertEquals(new TestExampleEntity(email: 'update@example.com'), $EntityFields->get_entity());
	}

	public function testAliasResolutionAndSource(): void
	{
		$F = new class extends Fields {
			public FieldEmailElement $email;

			public function __construct()
			{
				$this->email = new FieldEmailElement(name: 'e');
			}
		};

		$F->meld_values(['email' => 'prop@example.com', 'e' => 'alias@example.com']);
		$this->assertSame('prop@example.com', $F->get_values()['email']);
		$this->assertSame('email', $F->get_last_meld_key($F->email));

		$F->meld_values(['e' => 'alias2@example.com']);
		$this->assertSame('alias2@example.com', $F->get_values()['email']);
		$this->assertSame('e', $F->get_last_meld_key($F->email));
	}
}

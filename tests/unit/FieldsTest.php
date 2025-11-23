<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use MarkIngman\Fields\Element\ArrayFieldElement;
use MarkIngman\Fields\Element\EmailFieldElement;
use MarkIngman\Fields\Element\FileFieldElement;
use MarkIngman\Fields\Element\SelectFieldElement;
use MarkIngman\Fields\Element\TextFieldElement;
use MarkIngman\Fields\Exception\ConfigurationException;
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
				public TextFieldElement $text = new TextFieldElement()
			) {
			}
		};

		$this->assertSame(['text' => ''], $F->get_values());
		$F->meld_values(['unknown' => 'x', 'TEXT' => 'x', 'Text' => 'x', 'text:' => 'x']);
		$this->assertSame(['text' => ''], $F->get_values());
	}

	public function testMeldMatchFirstRule(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public TextFieldElement $text = new TextFieldElement(),
				public FileFieldElement $file = new FileFieldElement()
			) {
			}
		};

		$this->assertSame([
			'text' => '',
			'file' => [
				'name' => null,
				'full_path' => null,
				'type' => null,
				'tmp_name' => null,
				'error' => UPLOAD_ERR_NO_FILE,
				'size' => 0,
			]
		], $F->get_values());

		$F->meld_values(
			['text' => 'one'],
			['text' => 'two'],
			['text' => 'three'],
			[
				'file' => [
					'name' => 'note.txt',
					'full_path' => '/tmp/note.txt',
					'type' => 'text/plain',
					'tmp_name' => 'tmp/file',
					'error' => UPLOAD_ERR_OK,
					'size' => 10,
				]
			],
		);
		$this->assertSame([
			'text' => 'one',
			'file' => [
				'name' => 'note.txt',
				'full_path' => '/tmp/note.txt',
				'type' => 'text/plain',
				'tmp_name' => 'tmp/file',
				'error' => UPLOAD_ERR_OK,
				'size' => 10,
			]
		], $F->get_values());
	}

	public function testMeldDisabled(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public TextFieldElement $text = new TextFieldElement(),
				public EmailFieldElement $email = new EmailFieldElement(disabled: true)
			) {
			}
		};

		$this->assertSame(['text' => '', 'email' => '',], $F->get_values());

		$F->meld_values(['text' => 'test', 'email' => 'test@exampe.com']);
		$this->assertSame(['text' => 'test', 'email' => ''], $F->get_values());

		$F->email->disabled = false;

		$F->meld_values(['text' => 'update', 'email' => 'test@exampe.com']);
		$this->assertSame(['text' => 'update', 'email' => 'test@exampe.com'], $F->get_values());
	}

	public function testResetValues(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public TextFieldElement $text = new TextFieldElement(value: 'test')
			) {
			}
		};

		$this->assertEquals(['text' => 'test'], $F->get_values());
		$F->text->value = '123';
		$this->assertEquals(['text' => '123'], $F->get_values());
		$F->reset_values();
		$this->assertEquals(['text' => 'test'], $F->get_values());
	}

	public function testUpdateDefaultValues(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public TextFieldElement $text = new TextFieldElement(value: 'test'),
				public SelectFieldElement $sel = new SelectFieldElement(
					value: 'test', options: ['test' => 'Test', 'alt' => 'Alt']
				)
			) {
			}
		};

		$this->assertEquals(['text' => 'test', 'sel' => 'test'], $F->get_values());
		$F->text->value = '123';
		$F->sel->value = 'alt';
		$this->assertEquals(['text' => '123', 'sel' => 'alt'], $F->get_values());
		$F->update_default_values();
		$this->assertEquals(['text' => '123', 'sel' => 'alt'], $F->get_values());
		$F->text->value = 'test';
		$F->sel->value = 'test';
		$this->assertEquals(['text' => 'test', 'sel' => 'test'], $F->get_values());
		$F->reset_values();
		$this->assertEquals(['text' => '123', 'sel' => 'alt'], $F->get_values());
	}

	public function testValidateAndGetInvalids(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public TextFieldElement $text = new TextFieldElement(max_len: 2)
			) {
			}
		};

		$F->text->value = '123';
		$this->assertFalse($F->validate());
		$this->assertFalse($F->is_valid());
		$this->assertEquals(['text'], $F->get_invalids());
	}

	public function testValidateAndGetErrors(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public TextFieldElement $text = new TextFieldElement(max_len: 2)
			) {
			}
		};

		$F->text->value = '123';
		$this->assertFalse($F->validate());
		$this->assertFalse($F->is_valid());
		$this->assertEquals(['text' => FieldErrType::ERR_FORMAT], $F->get_errors());
	}

	public function testGetPropertyName(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public TextFieldElement $text = new TextFieldElement()
			) {
			}
		};

		$this->assertEquals('text', $F->get_property_name($F->text));
	}

	public function testAlternateNameAlias(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public ArrayFieldElement $tags = new ArrayFieldElement(
					name: 't',
				)
			) {
			}
		};

		$F->meld_values(['t' => ['a']]);
		$this->assertSame('t', $F->get_last_meld_key($F->tags));
		$this->assertSame(['a'], $F->get_values()['tags']);

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
			public EmailFieldElement $email;

			public function __construct()
			{
				$this->email = new EmailFieldElement(name: 'e');
			}
		};

		$F->meld_values(['email' => 'prop@example.com', 'e' => 'alias@example.com']);
		$this->assertSame('prop@example.com', $F->get_values()['email']);
		$this->assertSame('email', $F->get_last_meld_key($F->email));

		$F->meld_values(['e' => 'alias2@example.com']);
		$this->assertSame('alias2@example.com', $F->get_values()['email']);
		$this->assertSame('e', $F->get_last_meld_key($F->email));
	}

	public function testNamePropertyCollision(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public TextFieldElement $text = new TextFieldElement(),
				public TextFieldElement $text2 = new TextFieldElement(name: 'text')
			) {
			}
		};

		$this->expectException(ConfigurationException::class);
		$this->expectExceptionMessage("Name collision: 'text2 / text'");

		$F->current();
	}

	public function testNameNameCollision(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public TextFieldElement $text = new TextFieldElement(name: 't'),
				public ArrayFieldElement $tags = new ArrayFieldElement(name: 't')
			) {
			}
		};

		$this->expectException(ConfigurationException::class);
		$this->expectExceptionMessage("Name collision: 'tags / t'");

		$F->current();
	}

	public function testPropertyNameCollision(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public TextFieldElement $text = new TextFieldElement(name: 't'),
				public ArrayFieldElement $t = new ArrayFieldElement()
			) {
			}
		};

		$this->expectException(ConfigurationException::class);
		$this->expectExceptionMessage("Name collision: t is also a name");

		$F->current();
	}

}

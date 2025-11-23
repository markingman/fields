<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use MarkIngman\Fields\Element\FieldFileElement;
use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use PHPUnit\Framework\TestCase;
use const UPLOAD_ERR_NO_FILE;
use const UPLOAD_ERR_OK;

final class FieldFileMeldTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(FieldFileMeld::class, new FieldFileMeld());
	}

	public function testInvalidArgument(): void
	{
		$M = new FieldFileMeld();

		$this->expectException(UnexpectedTypeException::class);
		$this->expectExceptionMessage('Expected ' . FieldFileElement::class);

		$M(new Fields(), new FieldTextElement(), null);
	}

	public function testIgnoreDisabled(): void
	{
		$E = new FieldFileElement(disabled: true);

		$M = $E->get_meld();
		$M(new Fields(), $E, [
			'name' => 'note.txt',
			'full_path' => '/tmp/note.txt',
			'type' => 'text/plain',
			'tmp_name' => 'tmp/file',
			'error' => UPLOAD_ERR_OK,
			'size' => 10,
		]);

		$this->assertEquals([
			'name' => null,
			'full_path' => null,
			'type' => null,
			'tmp_name' => null,
			'error' => UPLOAD_ERR_NO_FILE,
			'size' => 0,
		], $E->value);
	}
}

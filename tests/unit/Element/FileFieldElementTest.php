<?php declare(strict_types=1);

namespace MarkIngman\Fields\Element;

use MarkIngman\Fields\FieldErrType;
use MarkIngman\Fields\Fields;
use MarkIngman\Fields\TestFileFieldFields;
use PHPUnit\Framework\TestCase;
use const UPLOAD_ERR_OK;
use const UPLOAD_ERR_NO_FILE;
use function sys_get_temp_dir;
use function file_put_contents;

final class FileFieldElementTest extends TestCase
{
	public function testFileField(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public FileFieldElement $file = new FileFieldElement()
			) {
			}
		};

		$F->meld_values([
			'file' => [
				'name' => 'note.txt',
				'full_path' => '/tmp/note.txt',
				'type' => 'text/plain',
				'tmp_name' => 'tmp/file',
				'error' => UPLOAD_ERR_OK,
				'size' => 10,
			]
		]);
		$this->assertSame([
			'file' => [
				'name' => 'note.txt',
				'full_path' => '/tmp/note.txt',
				'type' => 'text/plain',
				'tmp_name' => 'tmp/file',
				'error' => UPLOAD_ERR_OK,
				'size' => 10,
			]
		], $F->get_values());

		$F->update_default_values();
		$F->meld_values([
			'file' => [
				'name' => 'list.csv',
				'full_path' => '/tmp/list.txt',
				'type' => 'text/csv',
				'tmp_name' => 'tmp/file2',
				'error' => UPLOAD_ERR_EXTENSION,
				'size' => 10,
			]
		]);
		$F->reset_values();
		$this->assertSame([
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

	public function testUploadOK(): void
	{
		$F = new TestFileFieldFields();
		$tmp = $this->makeTmpFile("hello world\n");

		$F->meld_values([
			'file' => [
				'name' => 'note.txt',
				'type' => null,//expects text/plain
				'tmp_name' => $tmp,
				'error' => UPLOAD_ERR_OK,
				'size' => 12,
			]
		]);

		$this->assertTrue($F->validate());
		$this->assertSame('text/plain', $F->file->get_value_type());
	}

	public function testSizeTooLarge(): void
	{
		$F = new TestFileFieldFields();
		$tmp = $this->makeTmpFile("1234");

		$F->meld_values([
			'file' => [
				'name' => 'big.txt',
				'tmp_name' => $tmp,
				'error' => UPLOAD_ERR_OK,
				'size' => 9_999_999,
			]
		]);

		$this->assertFalse($F->validate());
		$this->assertSame(FieldErrType::ERR_SIZE, $F->file->err);
	}

	public function testMimeMismatch(): void
	{
		$F = new TestFileFieldFields();
		$png = "\x89PNG\r\n\x1a\n\x00\x00\x00\rIHDR";// fake PNG header; finfo should report image/png
		$tmp = $this->makeTmpFile($png);

		$F->meld_values([
			'file' => [
				'name' => 'img.png',
				'tmp_name' => $tmp,
				'error' => UPLOAD_ERR_OK,
				'size' => strlen($png),
			]
		]);

		$this->assertFalse($F->validate());
		$this->assertSame(FieldErrType::ERR_TYPE, $F->file->err);
	}

	public function testGetAcceptSuffix(): void
	{
		$F = new TestFileFieldFields();
		$this->assertEquals('txt', $F->file->get_accept_suffix());
	}

	public function testGetValueName(): void
	{
		$F = new TestFileFieldFields();

		$F->meld_values([
			'file' => [
				'name' => 'test.txt',
			]
		]);
		$this->assertEquals('test.txt', $F->file->get_value_name());
	}

	public function testGetValueFullPath(): void
	{
		$F = new TestFileFieldFields();
		$F->meld_values([
			'file' => [
				'full_path' => '/tmp/test.txt',
			]
		]);
		$this->assertEquals('/tmp/test.txt', $F->file->get_value_full_path());
	}


	public function testGetValueTmpName(): void
	{
		$F = new TestFileFieldFields();
		$F->meld_values([
			'file' => [
				'tmp_name' => 'tmp123',
			]
		]);
		$this->assertEquals('tmp123', $F->file->get_value_tmp_name());
	}


	public function testValidateNoFile(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public FileFieldElement $file = new FileFieldElement(),
			) {
			}
		};

		$F->meld_values([
			'file' => ['error' => UPLOAD_ERR_NO_FILE]
		]);

		$this->assertFalse($F->validate());
	}

	private function makeTmpFile(string $contents): string
	{
		$tmp = tempnam(sys_get_temp_dir(), 'ff_');
		file_put_contents($tmp, $contents);

		return $tmp;
	}
}

<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use PHPUnit\Framework\TestCase;

final class FieldFileElementTest extends TestCase
{
	public function testHappyPathPlainText(): void
	{
		$F = new TestFieldFileFields();
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
		$F = new TestFieldFileFields();
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
		$F = new TestFieldFileFields();
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
		$F = new TestFieldFileFields();
		$this->assertEquals('txt', $F->file->get_accept_suffix());
	}

	public function testGetValueName(): void
	{
		$F = new TestFieldFileFields();

		$F->meld_values([
			'file' => [
				'name' => 'test.txt',
				'type' => 'text/plain',
				'tmp_name' => 'tmp',
				'error' => UPLOAD_ERR_OK,
				'size' => 1,
			]
		]);
		$this->assertEquals('test.txt', $F->file->get_value_name());
	}

	public function testGetValueFullPath(): void
	{
		$F = new TestFieldFileFields();
		$F->meld_values([
			'file' => [
				'name' => 'test.txt',
				'full_path' => '/tmp/test.txt',
				'type' => 'text/plain',
				'tmp_name' => 'tmp',
				'error' => UPLOAD_ERR_OK,
				'size' => 1,
			]
		]);
		$this->assertEquals('/tmp/test.txt', $F->file->get_value_full_path());
	}

// 	public function testGetUploadedFileNotFound(): void
// 	{
// 		$F = new TestFieldFileFields();
// 
// 		$this->expectException(RuntimeException::class);
// 		$this->expectExceptionMessage('No file found');
// 
// 		$F->file->get_uploaded_file();
// 	}

//     public function testGetUploadedFileError(): void
//     {
//         $F = new TestFieldFileFields();
//         $tmp = $this->makeTmpFile('');// empty
// 
//         $F->meld_values(['file' => [
//             'name' => 'note.txt',
//             'type' => 'text/plain',
//             'tmp_name' => '/tmp/tmp',//$tmp,
//             'error' => UPLOAD_ERR_OK,
//             'size' => 100,
//         ]]);
// 
// 		$this->expectException(RuntimeException::class);
// 		$this->expectExceptionMessage('No file content');
// 
//         $F->file->get_uploaded_file();
// 	}

	public function testValidateNoFile(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public FieldFileElement $file = new FieldFileElement(),
			) {
			}
		};

		$F->meld_values([
			'file' => [
// 			'name' => 'test.txt',
// 			'type' => 'text/plain',
// 			'tmp_name' => $this->makeTmpFile("test\n"),
				'error' => UPLOAD_ERR_NO_FILE,
// 			'size' => 5,
			]
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

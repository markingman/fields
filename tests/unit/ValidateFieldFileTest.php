<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use finfo;
use InvalidArgumentException;
use MarkIngman\Fields\Element\FieldFileElement;
use MarkIngman\Fields\Element\FieldTextElement;
use MarkIngman\Fields\Validate\ValidateFieldFile;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class ValidateFieldFileTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(ValidateFieldFile::class, new ValidateFieldFile());
	}

	public function testInvalidArgument(): void
	{
		$V = new ValidateFieldFile();

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Expected FieldFileElement');

		$V(new Fields(), new FieldTextElement());
	}

	public function testSizeErr(): void
	{
		$V = new ValidateFieldFile();

		$F = new class extends Fields {
			public function __construct(
				public FieldFileElement $file = new FieldFileElement()
			) {
			}
		};

		$F->meld_values(['file' => ['error' => UPLOAD_ERR_INI_SIZE]]);

		$this->assertFalse($V($F, $F->file));
		$this->assertEquals(FieldErrType::ERR_SIZE, $F->file->err);
		$this->assertFalse($F->file->valid);

		$F->meld_values(['file' => ['error' => UPLOAD_ERR_FORM_SIZE]]);

		$this->assertFalse($V($F, $F->file));
		$this->assertEquals(FieldErrType::ERR_SIZE, $F->file->err);
		$this->assertFalse($F->file->valid);
	}

	public function testSystemErr(): void
	{
		$V = new ValidateFieldFile();

		$F = new class extends Fields {
			public function __construct(
				public FieldFileElement $file = new FieldFileElement()
			) {
			}
		};

		$F->meld_values(['file' => ['error' => UPLOAD_ERR_NO_TMP_DIR]]);

		$this->assertFalse($V($F, $F->file));
		$this->assertEquals(FieldErrType::ERR_SYSTEM, $F->file->err);
		$this->assertFalse($F->file->valid);

		$F->meld_values(['file' => ['error' => UPLOAD_ERR_CANT_WRITE]]);

		$this->assertFalse($V($F, $F->file));
		$this->assertEquals(FieldErrType::ERR_SYSTEM, $F->file->err);
		$this->assertFalse($F->file->valid);
	}

	public function testTypeErr(): void
	{
		$V = new ValidateFieldFile();

		$F = new class extends Fields {
			public function __construct(
				public FieldFileElement $file = new FieldFileElement()
			) {
			}
		};

		$F->meld_values(['file' => ['error' => UPLOAD_ERR_EXTENSION]]);

		$this->assertFalse($V($F, $F->file));
		$this->assertEquals(FieldErrType::ERR_TYPE, $F->file->err);
		$this->assertFalse($F->file->valid);
	}

	public function testUnknownErr(): void
	{
		$V = new ValidateFieldFile();

		$F = new class extends Fields {
			public function __construct(
				public FieldFileElement $file = new FieldFileElement()
			) {
			}
		};

		$F->meld_values(['file' => ['error' => null]]);

		$this->assertFalse($V($F, $F->file));
		$this->assertEquals(FieldErrType::ERR_EMPTY, $F->file->err);
		$this->assertFalse($F->file->valid);
	}

	public function testNoUploadedFile(): void
	{
		$V = new ValidateFieldFile();

		$F = new class extends Fields {
			public function __construct(
				public FieldFileElement $file = new FieldFileElement()
			) {
			}
		};

		$F->meld_values(['file' => ['error' => UPLOAD_ERR_OK]]);

		$this->assertFalse($V($F, $F->file));
		$this->assertEquals(FieldErrType::ERR_SYSTEM, $F->file->err);
		$this->assertFalse($F->file->valid);
	}

	public function testSizeTooLarge(): void
	{
		$V = new class extends ValidateFieldFile {
			protected function is_uploaded_file(string $filename): bool
			{
				return true;
			}
		};

		$F = new class extends Fields {
			public function __construct(
				public FieldFileElement $file = new FieldFileElement()
			) {
			}
		};

		$F->meld_values([
			'file' => [
				'error' => UPLOAD_ERR_OK,
				'size' => 9_999_999,
			]
		]);

		$this->assertFalse($V($F, $F->file));
		$this->assertEquals(FieldErrType::ERR_SIZE, $F->file->err);
		$this->assertFalse($F->file->valid);
	}

	public function testFileSuffix(): void
	{
		$F = new class extends Fields {
			public function __construct(
				public FieldFileElement $file = new FieldFileElement()
			) {
			}
		};

		$V = new class extends ValidateFieldFile {
			protected function is_uploaded_file(string $filename): bool
			{
				return true;
			}

			public function validate_mime(string $file_path, string $allowed_mime_types): string
			{
				return 'text/csv';
			}
		};

		$F->meld_values([
			'file' => [
				'name' => 'list.csv',
				'full_path' => '/tmp/list.txt',
				'type' => 'text/csv',
				'tmp_name' => 'tmp/file2',
				'error' => UPLOAD_ERR_OK,
				'size' => 10,
			]
		]);

		$this->assertFalse($V($F, $F->file));
		$this->assertEquals(FieldErrType::ERR_TYPE, $F->file->err);
	}

	public function testValidateMimeNoTypes(): void
	{
		$V = new ValidateFieldFile();

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('No mime types to check');

		$V->validate_mime('/tmp/test.txt', '');
	}

	public function testValidateMimeFinfoNotOpen(): void
	{
		$V = new class extends ValidateFieldFile {
			protected function finfo_open(int $flags = FILEINFO_NONE): finfo|false
			{
				return false;
			}
		};

		$this->expectException(RuntimeException::class);
		$this->expectExceptionMessage('Unable to open fileinfo');

		$V->validate_mime('/tmp/test.txt', 'text/plain');
	}

	public function testValidateMimeUndetermined(): void
	{
		$V = new class extends ValidateFieldFile {
			protected function finfo_file(finfo $finfo, string $filename): string|false
			{
				return false;
			}
		};

		$this->expectException(RuntimeException::class);
		$this->expectExceptionMessage('Unable to determine the MIME type');

		$V->validate_mime('/tmp/test.txt', 'text/plain');
	}

	public function testValidateMimeWildcard(): void
	{
		$V = new class extends ValidateFieldFile {
			protected function finfo_file(finfo $finfo, string $filename): string
			{
				return 'image/jpg';
			}
		};

		$this->assertEquals('image/jpg', $V->validate_mime('/tmp/image.jpg', 'image/*'));
	}
}

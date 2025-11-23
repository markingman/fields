<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use MarkIngman\Fields\Validate\FileFieldValidate;

class TestFileFieldValidate extends FileFieldValidate
{
	protected function is_uploaded_file(string $filename): bool
	{
		return strlen($filename) && is_file($filename);
	}
}

<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use MarkIngman\Fields\Validate\ValidateFieldFile;

class TestValidateFieldFile extends ValidateFieldFile
{
	protected function is_uploaded_file(string $filename): bool
	{
		return strlen($filename) && is_file($filename);
	}
}

<?php declare(strict_types=1);

namespace MarkIngman\Fields;

class TestValidateFieldFile extends ValidateFieldFile
{
	protected function is_uploaded_file(string $filename): bool
	{
		return strlen($filename) and is_file($filename);
	}
}

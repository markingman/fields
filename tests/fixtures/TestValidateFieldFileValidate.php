<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use MarkIngman\Fields\Validate\FieldFileValidate;

class TestValidateFieldFileValidate extends FieldFileValidate
{
	protected function is_uploaded_file(string $filename): bool
	{
		return strlen($filename) && is_file($filename);
	}
}

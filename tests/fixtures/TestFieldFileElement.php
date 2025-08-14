<?php declare(strict_types=1);

namespace MarkIngman\Fields;

class TestFieldFileElement extends FieldFileElement
{
	public function get_validator(): ValidateFieldFile
	{
		return new TestValidateFieldFile();
	}
}

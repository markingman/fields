<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use MarkIngman\Fields\Element\FieldFileElement;

class TestFieldFileElement extends FieldFileElement
{
	public function get_validator(): TestValidateFieldFileValidate
	{
		return new TestValidateFieldFileValidate();
	}
}


<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use MarkIngman\Fields\Element\FileFieldElement;

class TestFileFieldElement extends FileFieldElement
{
	public function get_validator(): TestFileFieldValidate
	{
		return new TestFileFieldValidate();
	}
}


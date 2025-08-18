<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use MarkIngman\Fields\Element\FieldFileElement;

class TestFileFields extends Fields
{
	public function __construct(
		public FieldFileElement $file = new FieldFileElement(
			required: true,
			size_max: 100,
			mime_type: 'text/plain',
			suffix: 'txt',
		)
	) {
	}
}

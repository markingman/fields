<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use MarkIngman\Fields\Element\FieldTextElement;

class TestTextFields extends Fields
{
	public function __construct(
		public FieldTextElement $text = new FieldTextElement(
			name: 't',
			label: 'Text',
			value: '',
		)
	) {
	}
}


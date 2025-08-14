<?php declare(strict_types=1);

namespace MarkIngman\Fields;

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


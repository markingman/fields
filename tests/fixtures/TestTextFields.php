<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use MarkIngman\Fields\Element\TextFieldElement;

class TestTextFields extends Fields
{
	public function __construct(
		public TextFieldElement $text = new TextFieldElement(
			name: 't',
			label: 'Text',
			value: '',
		)
	) {
	}
}


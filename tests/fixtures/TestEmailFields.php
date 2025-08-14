<?php declare(strict_types=1);

namespace MarkIngman\Fields;

class TestEmailFields extends Fields
{
	public function __construct(
		public FieldEmailElement $email = new FieldEmailElement(
			name: 'e',
			label: 'Email',
			value: '',
		)
	) {
	}
}


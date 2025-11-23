<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use MarkIngman\Fields\Element\EmailFieldElement;

class TestEmailFields extends Fields
{
	public function __construct(
		public EmailFieldElement $email = new EmailFieldElement(
			name: 'e',
			label: 'Email',
			value: '',
		)
	) {
	}
}


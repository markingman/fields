<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use MarkIngman\Fields\Element\BoolFieldElement;
use MarkIngman\Fields\Element\EmailFieldElement;
use MarkIngman\Fields\Element\TextFieldElement;

class TestEditFields extends Fields
{
	public function __construct(
		public TextFieldElement $id = new TextFieldElement(
			value: '0',
		),
		public TextFieldElement $name = new TextFieldElement(
			value: '',
		),
		public EmailFieldElement $email = new EmailFieldElement(
			value: '',
		),
		public BoolFieldElement $subscribe = new BoolFieldElement(
			value: '',
		),
	) {
	}
}


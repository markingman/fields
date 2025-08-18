<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use MarkIngman\Fields\Element\FieldBoolElement;
use MarkIngman\Fields\Element\FieldEmailElement;
use MarkIngman\Fields\Element\FieldTextElement;

class TestEditFields extends Fields
{
	public function __construct(
		public FieldTextElement $id = new FieldTextElement(
			value: '0',
		),
		public FieldTextElement $name = new FieldTextElement(
			value: '',
		),
		public FieldEmailElement $email = new FieldEmailElement(
			value: '',
		),
		public FieldBoolElement $subscribe = new FieldBoolElement(
			value: '',
		),
	) {
	}
}


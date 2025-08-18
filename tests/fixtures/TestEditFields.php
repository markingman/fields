<?php declare(strict_types=1);

namespace MarkIngman\Fields;

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


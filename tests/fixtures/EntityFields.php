<?php declare(strict_types=1);

namespace MarkIngman\Fields;

class EntityFields extends Fields
{
	public function __construct(
		public FieldEmailElement $email = new FieldEmailElement(
			name: 'e',
			label: 'Email',
			value: '',
		)
	) {
	}

	public function get_entity(): ExampleEntity
	{
		return new ExampleEntity(
			email: $this->email->value,
		);
	}

	public function meld_entity(ExampleEntity $ExampleEntity): void
	{
		$this->email->value = $ExampleEntity->email;
	}
}


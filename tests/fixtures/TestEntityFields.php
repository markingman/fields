<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use MarkIngman\Fields\Element\EmailFieldElement;

class TestEntityFields extends Fields
{
	public function __construct(
		public EmailFieldElement $email = new EmailFieldElement(
			name: 'e',
			label: 'Email',
			value: '',
		)
	) {
	}

	public function get_entity(): TestExampleEntity
	{
		return new TestExampleEntity(
			email: $this->email->value,
		);
	}

	public function meld_entity(TestExampleEntity $ExampleEntity): void
	{
		$this->email->value = $ExampleEntity->email;
	}
}


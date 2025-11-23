<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use MarkIngman\Fields\Element\EmailFieldElement;

class TestEmailElementFields extends Fields
{
	public EmailFieldElement $email;

	public function __construct(?int $min_len = null, ?int $max_len = null, ?bool $required = null)
	{
		$this->email = new EmailFieldElement(
			required: $required ?? true,
			max_len: $max_len ?? 200,
			min_len: $min_len ?? 3,
		);
	}
}


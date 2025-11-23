<?php declare(strict_types=1);

namespace MarkIngman\Fields\Element;

use MarkIngman\Fields\FieldErrType;
use MarkIngman\Fields\Meld\EmailFieldMeld;
use MarkIngman\Fields\Validate\EmailFieldValidate;

class EmailFieldElement extends TextFieldElement
{
	private ?EmailFieldMeld $meld = null;
	private ?EmailFieldValidate $validator = null;

	public function __construct(
		string $name = '',
		string $label = '',
		bool $valid = false,
		FieldErrType $err = FieldErrType::ERR_NONE,
		bool $required = false,
		bool $disabled = false,
		bool $display = true,
		string $value = '',
		int $max_len = 255,
		int $min_len = 3,
	) {
		parent::__construct(
			name: $name,
			label: $label,
			valid: $valid,
			err: $err,
			required: $required,
			disabled: $disabled,
			display: $display,
			value: $value,
			max_len: $max_len,
			min_len: $min_len,
		);
	}

	public function get_meld(): EmailFieldMeld
	{
		return $this->meld ??= new EmailFieldMeld();
	}

	public function get_validator(): EmailFieldValidate
	{
		return $this->validator ??= new EmailFieldValidate();
	}
}

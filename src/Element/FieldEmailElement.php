<?php declare(strict_types=1);

namespace MarkIngman\Fields\Element;

use MarkIngman\Fields\FieldErrType;
use MarkIngman\Fields\Meld\FieldEmailMeld;
use MarkIngman\Fields\Validate\FieldEmailValidate;

class FieldEmailElement extends FieldTextElement
{
	private ?FieldEmailMeld $meld = null;
	private ?FieldEmailValidate $validator = null;

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

	public function get_meld(): FieldEmailMeld
	{
		return $this->meld ??= new FieldEmailMeld();
	}

	public function get_validator(): FieldEmailValidate
	{
		return $this->validator ??= new FieldEmailValidate();
	}
}

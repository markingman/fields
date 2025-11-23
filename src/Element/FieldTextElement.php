<?php declare(strict_types=1);

namespace MarkIngman\Fields\Element;

use MarkIngman\Fields\FieldErrType;
use MarkIngman\Fields\Meld\FieldTextMeld;
use MarkIngman\Fields\Validate\FieldTextValidate;

class FieldTextElement extends AbstractFieldElement
{
	public string $default;
	private ?FieldTextMeld $meld = null;
	private ?FieldTextValidate $validator = null;

	public function __construct(
		string $name = '',
		string $label = '',
		bool $valid = false,
		FieldErrType $err = FieldErrType::ERR_NONE,
		bool $required = false,
		bool $disabled = false,
		bool $display = true,
		public string $value = '',
		protected int $max_len = 200,
		protected int $min_len = 0,
	) {
		$this->default = $value;
		parent::__construct(
			name: $name,
			label: $label,
			valid: $valid,
			err: $err,
			required: $required,
			disabled: $disabled,
			display: $display,
		);
	}

	public function reset_value(): void
	{
		$this->value = $this->default;
	}

	public function update_default_value(): void
	{
		$this->default = $this->value;
	}

	public function get_max_len(): int
	{
		return $this->max_len;
	}

	public function get_min_len(): int
	{
		return $this->min_len;
	}

	public function get_meld(): FieldTextMeld
	{
		return $this->meld ??= new FieldTextMeld();
	}

	public function get_validator(): FieldTextValidate
	{
		return $this->validator ??= new FieldTextValidate();
	}
}

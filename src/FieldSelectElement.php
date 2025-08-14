<?php declare(strict_types=1);

namespace MarkIngman\Fields;

class FieldSelectElement extends AbstractFieldElement
{
	public string $default;
	private ?MeldFieldSelect $meld = null;
	private ?ValidateFieldSelect $validator = null;

	/** @param array<int|string, string> $options */
	public function __construct(
		string $name = '',
		string $label = '',
		bool $valid = false,
		FieldErrType $err = FieldErrType::ERR_NONE,
		bool $required = false,
		bool $disabled = false,
		bool $display = true,
		public string $value = '',
		public array $options = [],
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

	public function get_meld(): MeldFieldSelect
	{
		return $this->meld ??= new MeldFieldSelect();
	}

	public function get_validator(): ValidateFieldSelect
	{
		return $this->validator ??= new ValidateFieldSelect();
	}

	public function get_label(string $value): ?string
	{
		return $this->options[$value] ?? null;
	}

	public function get_selected_label(): ?string
	{
		return $this->get_label($this->value);
	}
}

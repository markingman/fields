<?php declare(strict_types=1);

namespace MarkIngman\Fields\Element;

use InvalidArgumentException;
use MarkIngman\Fields\FieldErrType;
use MarkIngman\Fields\Meld\MeldFieldBool;
use MarkIngman\Fields\Validate\ValidateFieldBool;

class FieldBoolElement extends AbstractFieldElement
{
	public string $default;
	private ?MeldFieldBool $meld = null;
	private ?ValidateFieldBool $validator = null;

	public function __construct(
		string $name = '',
		string $label = '',
		bool $valid = false,
		FieldErrType $err = FieldErrType::ERR_NONE,
		bool $required = false,
		bool $disabled = false,
		bool $display = true,
		public string $value = '',
		public string $option = 'yes',
		public string $option_empty = '',
	) {
		$this->default = $value;

		if ($value !== $option && $value !== $option_empty) {
			throw new InvalidArgumentException('Value not in options');
		}

		if ($option === $option_empty) {
			throw new InvalidArgumentException('Options must be different');
		}

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

	public function get_meld(): MeldFieldBool
	{
		return $this->meld ??= new MeldFieldBool();
	}

	public function get_validator(): ValidateFieldBool
	{
		return $this->validator ??= new ValidateFieldBool();
	}

	public function checked(): bool
	{
		return $this->value === $this->option;
	}
}

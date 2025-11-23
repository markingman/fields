<?php declare(strict_types=1);

namespace MarkIngman\Fields\Element;

use MarkIngman\Fields\Exception\ConfigurationException;
use MarkIngman\Fields\FieldErrType;
use MarkIngman\Fields\Meld\FieldBoolMeld;
use MarkIngman\Fields\Validate\FieldBoolValidate;

class FieldBoolElement extends AbstractFieldElement
{
	public string $default;
	private ?FieldBoolMeld $meld = null;
	private ?FieldBoolValidate $validator = null;

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
			throw new ConfigurationException('Value not in options');
		}

		if ($option === $option_empty) {
			throw new ConfigurationException('Options must be different');
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

	public function get_meld(): FieldBoolMeld
	{
		return $this->meld ??= new FieldBoolMeld();
	}

	public function get_validator(): FieldBoolValidate
	{
		return $this->validator ??= new FieldBoolValidate();
	}

	public function checked(): bool
	{
		return $this->value === $this->option;
	}
}

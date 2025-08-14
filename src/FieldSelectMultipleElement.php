<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use function array_flip;
use function array_intersect_key;
use function array_values;

class FieldSelectMultipleElement extends FieldArrayElement
{
	private ?MeldFieldSelectMultiple $meld = null;
	private ?ValidateFieldSelectMultiple $validator = null;

	/**
	 * @param string[] $value
	 * @param array<string, string> $options
	 */
	public function __construct(
		string $name = '',
		string $label = '',
		bool $valid = false,
		FieldErrType $err = FieldErrType::ERR_NONE,
		bool $required = false,
		bool $disabled = false,
		bool $display = true,
		public array $value = [],
		public array $options = [],
	) {
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

	public function get_meld(): MeldFieldSelectMultiple
	{
		return $this->meld ??= new MeldFieldSelectMultiple();
	}

	public function get_validator(): ValidateFieldSelectMultiple
	{
		return $this->validator ??= new ValidateFieldSelectMultiple();
	}

	/**
	 * @param string[] $value
	 * @return string[]
	 */
	public function get_labels(array $value): array
	{
		return array_values(array_intersect_key($this->options, array_flip($value)));
	}

	/** @return string[] */
	public function get_selected_labels(): array
	{
		return $this->get_labels($this->value);
	}
}

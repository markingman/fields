<?php declare(strict_types=1);

namespace MarkIngman\Fields\Element;

use InvalidArgumentException;
use MarkIngman\Fields\Exception\ConfigurationException;
use MarkIngman\Fields\FieldErrType;
use MarkIngman\Fields\Meld\MeldFieldSelectMultiple;
use MarkIngman\Fields\Validate\ValidateFieldSelectMultiple;
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
	 * @param array<string> $null_values
	 */
	public function __construct(
		string $name = '',
		string $label = '',
		bool $valid = false,
		FieldErrType $err = FieldErrType::ERR_NONE,
		bool $required = false,
		bool $disabled = false,
		bool $display = true,
		array $value = [],
		int $max_count = 100,
		int $max_len = 200,
		int $min_len = 0,
		public array $options = [],
		public array $null_values = [],// the first value is the default null value
		public false|string $all_value = false,
	) {
		$keys = array_keys($options);

		if ($value && array_diff($value, $keys)) {
			throw new ConfigurationException('Values must be options');
		}

		if ($null_values && array_diff($null_values, $keys)) {
			throw new ConfigurationException('Null values must be options');
		}

		if ($all_value !== false && !isset($options[$all_value])) {
			throw new ConfigurationException('All-value must be an option');
		}

		parent::__construct(
			name: $name,
			label: $label,
			valid: $valid,
			err: $err,
			required: $required,
			disabled: $disabled,
			display: $display,
			value: $value,
			max_count: $max_count,
			max_len: $max_len,
			min_len: $min_len,
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

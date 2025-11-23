<?php declare(strict_types=1);

namespace MarkIngman\Fields\Element;

use MarkIngman\Fields\FieldErrType;
use MarkIngman\Fields\Meld\MeldFieldInterface;
use MarkIngman\Fields\Validate\ValidateFieldInterface;

abstract class AbstractFieldElement
{
	protected function __construct(
		public readonly string $name = '',
		public string $label = '',
		public bool $valid = false,
		public FieldErrType $err = FieldErrType::ERR_NONE,
		public bool $required = false,
		public bool $disabled = false,
		public bool $display = true,
	) {
	}

	public abstract function reset_value(): void;

	public abstract function update_default_value(): void;

	public function get_meld(): ?MeldFieldInterface
	{
		return null;
	}

	public function get_validator(): ?ValidateFieldInterface
	{
		return null;
	}
}

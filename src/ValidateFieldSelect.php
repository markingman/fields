<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;

class ValidateFieldSelect implements ValidateFieldInterface
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element): bool
	{
		if (!$Element instanceof FieldSelectElement) {
			throw new InvalidArgumentException('Expected FieldSelectElement');
		}

		if ($Element->required && $Element->value === '') {
			$Element->valid = false;
			$Element->err = FieldErrType::ERR_EMPTY;
		} elseif (!isset($Element->options[$Element->value])) {
			$Element->valid = false;
			$Element->err = FieldErrType::ERR_FORMAT;
		} else {
			$Element->valid = true;
			$Element->err = FieldErrType::ERR_NONE;
		}

		return $Element->valid;
	}
}

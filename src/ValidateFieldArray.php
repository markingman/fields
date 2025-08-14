<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;

class ValidateFieldArray implements ValidateFieldInterface
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element): bool
	{
		if (!$Element instanceof FieldArrayElement) {
			throw new InvalidArgumentException('Expected FieldArrayElement');
		}

		if ($Element->required && $Element->value === []) {
			$Element->valid = false;
			$Element->err = FieldErrType::ERR_EMPTY;
		} else {
			$Element->valid = true;
			$Element->err = FieldErrType::ERR_NONE;
		}

		return $Element->valid;
	}
}

<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;

class ValidateFieldBool implements ValidateFieldInterface
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element): bool
	{
		if (!$Element instanceof FieldBoolElement) {
			throw new InvalidArgumentException('Expected FieldBoolElement');
		}

		if ($Element->required and $Element->value === $Element->option_empty) {
			$Element->valid = false;
			$Element->err = FieldErrType::ERR_EMPTY;
		} elseif ($Element->value !== $Element->option_empty and $Element->value !== $Element->option) {
			$Element->valid = false;
			$Element->err = FieldErrType::ERR_FORMAT;
		} else {
			$Element->valid = true;
			$Element->err = FieldErrType::ERR_NONE;
		}

		return $Element->valid;
	}
}

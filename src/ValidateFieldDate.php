<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use DateTime;
use InvalidArgumentException;

class ValidateFieldDate extends ValidateFieldText
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element): bool
	{
		if (!$Element instanceof FieldDateElement) {
			throw new InvalidArgumentException('Expected FieldDateElement');
		}

		if ($Element->value === '') {
			if ($Element->required) {
				$Element->valid = false;
				$Element->err = FieldErrType::ERR_EMPTY;
			} else {
				$Element->valid = true;
				$Element->err = FieldErrType::ERR_NONE;
			}
		} else {
			$DateTime = DateTime::createFromFormat('Y-m-d', $Element->value);
			if (!($DateTime && $DateTime->format('Y-m-d') === $Element->value)) {
				$Element->valid = false;
				$Element->err = FieldErrType::ERR_FORMAT;
			} else {
				$Element->valid = true;
				$Element->err = FieldErrType::ERR_NONE;
			}
		}

		return $Element->valid;
	}
}

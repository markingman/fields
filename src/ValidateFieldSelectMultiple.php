<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
use function array_diff_key;
use function array_flip;

class ValidateFieldSelectMultiple extends ValidateFieldArray
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element): bool
	{
		if (!$Element instanceof FieldSelectMultipleElement) {
			throw new InvalidArgumentException('Expected FieldSelectMultipleElement');
		}

		if ($Element->required and $Element->value === []) {
			$Element->valid = false;
			$Element->err = FieldErrType::ERR_EMPTY;
		} elseif (array_diff_key(array_flip($Element->value), $Element->options) !== []) {
			$Element->valid = false;
			$Element->err = FieldErrType::ERR_FORMAT;
		} else {
			$Element->valid = true;
			$Element->err = FieldErrType::ERR_NONE;
		}

		return $Element->valid;
	}
}

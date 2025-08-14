<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
use function mb_strlen;

class ValidateFieldText implements ValidateFieldInterface
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element): bool
	{
		if (!$Element instanceof FieldTextElement) {
			throw new InvalidArgumentException('Expected FieldTextElement');
		}

		if ($Element->required and $Element->value === '') {
			$Element->valid = false;
			$Element->err = FieldErrType::ERR_EMPTY;
		} elseif (!$Element->required and $Element->value === '') {
			$Element->valid = true;
			$Element->err = FieldErrType::ERR_NONE;
		} elseif (
			mb_strlen($Element->value) < $Element->get_min_len()
			or mb_strlen($Element->value) > $Element->get_max_len()
		) {
			$Element->valid = false;
			$Element->err = FieldErrType::ERR_FORMAT;
		} else {
			$Element->valid = true;
			$Element->err = FieldErrType::ERR_NONE;
		}

		return $Element->valid;
	}
}

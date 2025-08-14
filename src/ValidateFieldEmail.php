<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
use function filter_var;
use function mb_strlen;
use const FILTER_FLAG_EMAIL_UNICODE;
use const FILTER_VALIDATE_EMAIL;

class ValidateFieldEmail extends ValidateFieldText
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element): bool
	{
		if (!$Element instanceof FieldEmailElement) {
			throw new InvalidArgumentException('Expected FieldEmailElement');
		}

		if ($Element->required && $Element->value === '') {
			$Element->valid = false;
			$Element->err = FieldErrType::ERR_EMPTY;
		} elseif (!$Element->required && $Element->value === '') {
			$Element->valid = true;
			$Element->err = FieldErrType::ERR_NONE;
		} elseif (
			mb_strlen($Element->value) < $Element->get_min_len()
			or mb_strlen($Element->value) > $Element->get_max_len()
			or !filter_var($Element->value, FILTER_VALIDATE_EMAIL, FILTER_FLAG_EMAIL_UNICODE)
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

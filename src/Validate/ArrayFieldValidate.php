<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\AbstractFieldElement;
use MarkIngman\Fields\Element\ArrayFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\FieldErrType;
use MarkIngman\Fields\Fields;

class ArrayFieldValidate implements ValidateFieldInterface
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element): bool
	{
		if (!$Element instanceof ArrayFieldElement) {
			throw new UnexpectedTypeException('Expected ' . ArrayFieldElement::class);
		}

		if ($Element->required && $Element->value === []) {
			$Element->valid = false;
			$Element->err = FieldErrType::ERR_EMPTY;
		} elseif (!$Element->required && $Element->value === []) {
			$Element->valid = true;
			$Element->err = FieldErrType::ERR_NONE;
		} elseif (count($Element->value) > $Element->get_max_count()) {
			$Element->valid = false;
			$Element->err = FieldErrType::ERR_FORMAT;
		} else {
			foreach ($Element->value as $it) {
				if (
					mb_strlen($it) < $Element->get_min_len()
					or mb_strlen($it) > $Element->get_max_len()
				) {
					$Element->valid = false;
					$Element->err = FieldErrType::ERR_FORMAT;

					return $Element->valid;
				}
			}

			$Element->valid = true;
			$Element->err = FieldErrType::ERR_NONE;
		}

		return $Element->valid;
	}
}

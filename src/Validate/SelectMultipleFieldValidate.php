<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\AbstractFieldElement;
use MarkIngman\Fields\Element\SelectMultipleFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\FieldErrType;
use MarkIngman\Fields\Fields;
use function array_diff_key;
use function array_flip;

class SelectMultipleFieldValidate extends ArrayFieldValidate
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element): bool
	{
		if (!$Element instanceof SelectMultipleFieldElement) {
			throw new UnexpectedTypeException('Expected ' . SelectMultipleFieldElement::class);
		}

		if ($Element->required && $Element->value === []) {
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

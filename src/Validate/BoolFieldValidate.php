<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\AbstractFieldElement;
use MarkIngman\Fields\Element\BoolFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\FieldErrType;
use MarkIngman\Fields\Fields;

class BoolFieldValidate implements ValidateFieldInterface
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element): bool
	{
		if (!$Element instanceof BoolFieldElement) {
			throw new UnexpectedTypeException('Expected ' . BoolFieldElement::class);
		}

		if ($Element->required && $Element->value === $Element->option_empty) {
			$Element->valid = false;
			$Element->err = FieldErrType::ERR_EMPTY;
		} elseif ($Element->value !== $Element->option_empty && $Element->value !== $Element->option) {
			$Element->valid = false;
			$Element->err = FieldErrType::ERR_FORMAT;
		} else {
			$Element->valid = true;
			$Element->err = FieldErrType::ERR_NONE;
		}

		return $Element->valid;
	}
}

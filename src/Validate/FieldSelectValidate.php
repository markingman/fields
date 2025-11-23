<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\AbstractFieldElement;
use MarkIngman\Fields\Element\FieldSelectElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\FieldErrType;
use MarkIngman\Fields\Fields;

class FieldSelectValidate implements FieldValidateInterface
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element): bool
	{
		if (!$Element instanceof FieldSelectElement) {
			throw new UnexpectedTypeException('Expected ' . FieldSelectElement::class);
		}

		if ($Element->required && in_array($Element->value, $Element->null_values)) {
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

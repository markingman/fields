<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\AbstractFieldElement;
use MarkIngman\Fields\Element\FieldBoolElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\FieldErrType;
use MarkIngman\Fields\Fields;

class FieldBoolValidate implements FieldValidateInterface
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element): bool
	{
		if (!$Element instanceof FieldBoolElement) {
			throw new UnexpectedTypeException('Expected ' . FieldBoolElement::class);
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

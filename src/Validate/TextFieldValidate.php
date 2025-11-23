<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\AbstractFieldElement;
use MarkIngman\Fields\Element\TextFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\FieldErrType;
use MarkIngman\Fields\Fields;
use function mb_strlen;

class TextFieldValidate implements ValidateFieldInterface
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element): bool
	{
		if (!$Element instanceof TextFieldElement) {
			throw new UnexpectedTypeException('Expected ' . TextFieldElement::class);
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

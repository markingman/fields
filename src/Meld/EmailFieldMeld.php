<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use MarkIngman\Fields\Element\AbstractFieldElement;
use MarkIngman\Fields\Element\EmailFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use function is_string;
use function mb_strlen;
use function trim;

class EmailFieldMeld extends TextFieldMeld
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element, mixed $value): void
	{
		if (!$Element instanceof EmailFieldElement) {
			throw new UnexpectedTypeException('Expected ' . EmailFieldElement::class);
		}

		if ($Element->disabled) {
			return;
		}

		if (is_string($value)) {
			$value = trim($value);
			if (mb_strlen($value) <= $Element->get_max_len()) {
				$Element->value = mb_strtolower($value);//using mb for possible Unicode values
			}
		}
	}
}

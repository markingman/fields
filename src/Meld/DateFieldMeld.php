<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use MarkIngman\Fields\Element\AbstractFieldElement;
use MarkIngman\Fields\Element\DateFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use function is_string;
use function preg_match;
use function strlen;
use function trim;

class DateFieldMeld extends TextFieldMeld
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element, mixed $value): void
	{
		if (!$Element instanceof DateFieldElement) {
			throw new UnexpectedTypeException('Expected ' . DateFieldElement::class);
		}

		if ($Element->disabled) {
			return;
		}

		if (is_string($value)) {
			$value = trim($value);
			if (strlen($value) === 10 && preg_match('~^[0-9]{4}-[0-9]{2}-[0-9]{2}$~', $value)) {
				$Element->value = $value;
			}
		}
	}
}

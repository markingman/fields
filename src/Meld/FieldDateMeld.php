<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use MarkIngman\Fields\Element\AbstractFieldElement;
use MarkIngman\Fields\Element\FieldDateElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use function is_string;
use function preg_match;
use function strlen;
use function trim;

class FieldDateMeld extends FieldTextMeld
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element, mixed $value): void
	{
		if (!$Element instanceof FieldDateElement) {
			throw new UnexpectedTypeException('Expected ' . FieldDateElement::class);
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

<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use MarkIngman\Fields\Element\AbstractFieldElement;
use MarkIngman\Fields\Element\FieldSelectElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use function is_string;

class FieldSelectMeld implements FieldMeldInterface
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element, mixed $value): void
	{
		if (!$Element instanceof FieldSelectElement) {
			throw new UnexpectedTypeException('Expected ' . FieldSelectElement::class);
		}

		if ($Element->disabled) {
			return;
		}

		if (is_string($value) && isset($Element->options[$value])) {
			$Element->value = $value;
		}
	}
}

<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use MarkIngman\Fields\Element\AbstractFieldElement;
use MarkIngman\Fields\Element\SelectFieldMultipleElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use function array_keys;
use function in_array;
use function is_array;

class SelectFieldMultipleMeld extends ArrayFieldMeld
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element, mixed $value): void
	{
		if (!$Element instanceof SelectFieldMultipleElement) {
			throw new UnexpectedTypeException('Expected ' . SelectFieldMultipleElement::class);
		}

		if ($Element->disabled) {
			return;
		}

		if (is_array($value) && (count($value) <= $Element->get_max_count())) {
			// If all-value default to just that
			if ($Element->all_value !== false && in_array($Element->all_value, $value)) {
				$Element->value = [$Element->all_value];
			} else {
				foreach (array_keys($Element->options) as $k) {
					if (in_array($k, $value, true) && !in_array($k, $Element->value, true)) {
						$Element->value[] = $k;
					}
				}

				// If null-values and real values, omit null-values
				$null_values = array_intersect($Element->value, $Element->null_values);
				if ($null_values && count($null_values) < count($Element->value)) {
					$Element->value = array_values(array_diff($Element->value, $Element->null_values));
				}

				// If no value and there are null-values, set to default (first) null-value
				if ($Element->value === [] && $Element->null_values) {
					$Element->value = [$Element->null_values[0]];
				}
			}
		}
	}
}

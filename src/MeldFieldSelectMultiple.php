<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
use function array_keys;
use function in_array;
use function is_array;

class MeldFieldSelectMultiple extends MeldFieldArray
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element, mixed $value): void
	{
		if (!$Element instanceof FieldSelectMultipleElement) {
			throw new InvalidArgumentException('Expected FieldSelectMultipleElement');
		}

		if ($Element->disabled) {
			return;
		}

		if (is_array($value)) {
			// If all-value default to just that
			if ($Element->all_value !== false and in_array($Element->all_value, $value)) {
				$Element->value = [$Element->all_value];
			} else {
				foreach (array_keys($Element->options) as $k) {
					if (in_array($k, $value, true) && !in_array($k, $Element->value, true)) {
						$Element->value[] = $k;
					}
				}

				// If null-values and real values, omit null-values
				$null_values = array_intersect($Element->value, $Element->null_values);
				if (count($null_values) < count($Element->value)) {
					$Element->value = array_diff($Element->value, $Element->null_values);
				}
								
				// If no value and there are null-values, set to default (first) null-value
				if ($Element->value === [] and $Element->null_values) {
					$Element->value = [$Element->null_values[0]];
				}
			}
		}
	}
}

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

		if (is_array($value)) {
			foreach (array_keys($Element->options) as $k) {
				if (in_array($k, $value, true) && !in_array($k, $Element->value, true)) {
					$Element->value[] = $k;
				}
			}
		}
	}
}

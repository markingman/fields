<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
use function count;
use function in_array;
use function is_array;
use function is_string;
use function mb_strlen;
use function trim;

class MeldFieldArray implements MeldFieldInterface
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element, mixed $value): void
	{
		if (!$Element instanceof FieldArrayElement) {
			throw new InvalidArgumentException('Expected FieldArrayElement');
		}

		if (is_array($value) && (count($value) <= $Element->get_max_count())) {
			foreach ($value as $it) {
				if (!is_string($it)) {
					continue;
				}
				$it = trim($it);
				if (
					mb_strlen($it) <= $Element->get_max_len()
					and mb_strlen($it) >= $Element->get_min_len()
					and !in_array($it, $Element->value, true)
				) {
					$Element->value[] = $it;
				}
			}
		}
	}
}

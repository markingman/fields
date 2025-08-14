<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
use function is_string;
use function mb_strlen;
use function strtolower;
use function trim;

class MeldFieldEmail extends MeldFieldText
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element, mixed $value): void
	{
		if (!$Element instanceof FieldEmailElement) {
			throw new InvalidArgumentException('Expected FieldEmailElement');
		}

		if (is_string($value)) {
			$value = trim($value);
			if (mb_strlen($value) <= $Element->get_max_len()) {
				$Element->value = strtolower($value);
			}
		}
	}
}

<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
use function is_string;
use function preg_match;
use function strlen;
use function trim;

class MeldFieldDate extends MeldFieldText
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element, mixed $value): void
	{
		if (!$Element instanceof FieldDateElement) {
			throw new InvalidArgumentException('Expected FieldDateElement');
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

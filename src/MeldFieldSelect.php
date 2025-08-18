<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
use function is_string;

class MeldFieldSelect implements MeldFieldInterface
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element, mixed $value): void
	{
		if (!$Element instanceof FieldSelectElement) {
			throw new InvalidArgumentException('Expected FieldSelectElement');
		}

		if ($Element->disabled) {
			return;
		}

		if (is_string($value) && isset($Element->options[$value])) {
			$Element->value = $value;
		}
	}
}

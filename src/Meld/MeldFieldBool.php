<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use InvalidArgumentException;
use MarkIngman\Fields\Element\AbstractFieldElement;
use MarkIngman\Fields\Element\FieldBoolElement;
use MarkIngman\Fields\Fields;
use function is_null;

class MeldFieldBool implements MeldFieldInterface
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element, mixed $value): void
	{
		if (!$Element instanceof FieldBoolElement) {
			throw new InvalidArgumentException('Expected FieldBoolElement');
		}

		if ($Element->disabled) {
			return;
		}

		if (is_null($value)) {
			$value = '';
		}

		if ($value === $Element->option || $value === $Element->option_empty) {
			$Element->value = $value;
		}
	}
}

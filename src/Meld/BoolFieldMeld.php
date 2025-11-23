<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use MarkIngman\Fields\Element\AbstractFieldElement;
use MarkIngman\Fields\Element\BoolFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use function is_null;

class BoolFieldMeld implements MeldFieldInterface
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element, mixed $value): void
	{
		if (!$Element instanceof BoolFieldElement) {
			throw new UnexpectedTypeException('Expected ' . BoolFieldElement::class);
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

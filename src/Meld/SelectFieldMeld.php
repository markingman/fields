<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use MarkIngman\Fields\Element\AbstractFieldElement;
use MarkIngman\Fields\Element\SelectFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use function is_string;

class SelectFieldMeld implements MeldFieldInterface
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element, mixed $value): void
	{
		if (!$Element instanceof SelectFieldElement) {
			throw new UnexpectedTypeException('Expected ' . SelectFieldElement::class);
		}

		if ($Element->disabled) {
			return;
		}

		if (is_string($value) && isset($Element->options[$value])) {
			$Element->value = $value;
		}
	}
}

<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use MarkIngman\Fields\Element\AbstractFieldElement;
use MarkIngman\Fields\Element\TextFieldElement;
use MarkIngman\Fields\Exception\UnexpectedTypeException;
use MarkIngman\Fields\Fields;
use function is_string;
use function mb_strlen;
use function trim;

class TextFieldMeld implements MeldFieldInterface
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element, mixed $value): void
	{
		if (!$Element instanceof TextFieldElement) {
			throw new UnexpectedTypeException('Expected ' . TextFieldElement::class);
		}

		if ($Element->disabled) {
			return;
		}

		if (is_string($value)) {
			$value = trim($value);
			if (mb_strlen($value) <= $Element->get_max_len()) {
				$Element->value = $value;
			}
		}
	}
}

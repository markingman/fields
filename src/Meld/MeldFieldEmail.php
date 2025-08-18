<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use InvalidArgumentException;
use MarkIngman\Fields\Element\AbstractFieldElement;
use MarkIngman\Fields\Element\FieldEmailElement;
use MarkIngman\Fields\Fields;
use function is_string;
use function mb_strlen;
use function trim;

class MeldFieldEmail extends MeldFieldText
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element, mixed $value): void
	{
		if (!$Element instanceof FieldEmailElement) {
			throw new InvalidArgumentException('Expected FieldEmailElement');
		}

		if ($Element->disabled) {
			return;
		}

		if (is_string($value)) {
			$value = trim($value);
			if (mb_strlen($value) <= $Element->get_max_len()) {
				$Element->value = mb_strtolower($value);//using mb for possible Unicode values
			}
		}
	}
}

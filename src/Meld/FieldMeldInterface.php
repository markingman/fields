<?php declare(strict_types=1);

namespace MarkIngman\Fields\Meld;

use MarkIngman\Fields\Element\AbstractFieldElement;
use MarkIngman\Fields\Fields;

interface FieldMeldInterface
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element, mixed $value): void;
}

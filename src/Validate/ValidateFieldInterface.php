<?php declare(strict_types=1);

namespace MarkIngman\Fields\Validate;

use MarkIngman\Fields\Element\AbstractFieldElement;
use MarkIngman\Fields\Fields;

interface ValidateFieldInterface
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element): bool;
}

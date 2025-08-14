<?php declare(strict_types=1);

namespace MarkIngman\Fields;

interface ValidateFieldInterface
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element): bool;
}

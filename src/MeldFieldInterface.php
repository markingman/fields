<?php declare(strict_types=1);

namespace MarkIngman\Fields;

interface MeldFieldInterface
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element, mixed $value): void;
}

<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use MarkIngman\Fields\Element\ArrayFieldElement;

class TestArrayFields extends Fields
{
	public function __construct(
		public ArrayFieldElement $tags = new ArrayFieldElement(
			value: [],
			max_len: 5,
		)
	) {
	}
}


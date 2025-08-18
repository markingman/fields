<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use MarkIngman\Fields\Element\FieldArrayElement;

class TestArrayFields extends Fields
{
	public function __construct(
		public FieldArrayElement $tags = new FieldArrayElement(
			value: [],
			max_len: 5,
		)
	) {
	}
}


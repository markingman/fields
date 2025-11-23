<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use MarkIngman\Fields\Element\BoolFieldElement;

class TestBoolFields extends Fields
{
	public function __construct(
		public BoolFieldElement $flag = new BoolFieldElement(
			label: 'Flag',
			value: '',
			option: 'on',
			option_empty: ''
		)
	) {
	}
}


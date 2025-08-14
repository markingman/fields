<?php declare(strict_types=1);

namespace MarkIngman\Fields;

class TestBoolFields extends Fields
{
	public function __construct(
		public FieldBoolElement $flag = new FieldBoolElement(
			label: 'Flag',
			value: '',
			option: 'on',
			option_empty: ''
		)
	) {
	}
}


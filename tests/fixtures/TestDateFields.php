<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use MarkIngman\Fields\Element\FieldDateElement;

class TestDateFields extends Fields
{
	public function __construct(
		public FieldDateElement $date = new FieldDateElement(
			name: 'd',
			label: 'Date',
			value: '',
		)
	) {
	}
}


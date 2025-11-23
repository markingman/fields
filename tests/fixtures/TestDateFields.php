<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use MarkIngman\Fields\Element\DateFieldElement;

class TestDateFields extends Fields
{
	public function __construct(
		public DateFieldElement $date = new DateFieldElement(
			name: 'd',
			label: 'Date',
			value: '',
		)
	) {
	}
}


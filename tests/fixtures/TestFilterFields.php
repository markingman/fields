<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use MarkIngman\Fields\Element\SelectFieldElement;
use MarkIngman\Fields\Element\SelectFieldMultipleElement;
use MarkIngman\Fields\Element\TextFieldElement;

class TestFilterFields extends Fields
{
	public function __construct(
		public TextFieldElement $query = new TextFieldElement(
			name: 'q',
			value: '',
			max_len: 4,
		),
		public SelectFieldElement $status = new SelectFieldElement(
			name: 's',
			value: '',
			options: ['' => '', 'a' => 'A', 'b' => 'B'],
			null_values: [''],
		),
		public SelectFieldMultipleElement $types = new SelectFieldMultipleElement(
			name: 't',
			value: [''],
			max_count: 2,
			options: ['' => '', 'a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'C'],
			null_values: [''],
		),
	) {
	}
}


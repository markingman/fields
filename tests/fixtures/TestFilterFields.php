<?php declare(strict_types=1);

namespace MarkIngman\Fields;

class TestFilterFields extends Fields
{
	public function __construct(
		public FieldTextElement $query = new FieldTextElement(
			name: 'q',
			value: '',
			max_len: 4,
		),
		public FieldSelectElement $status = new FieldSelectElement(
			name: 's',
			value: '',
			options: ['' => '', 'a' => 'A', 'b' => 'B'],
			null_values: [''],
		),
		public FieldSelectMultipleElement $types = new FieldSelectMultipleElement(
			name: 't',
			value: [''],
			options: ['' => '', 'a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'C'],
			null_values: [''],
			max_count: 2,
		),
	) {
	}
}


<?php declare(strict_types=1);

namespace MarkIngman\Fields;

class TestFieldFileFields extends Fields
{
	public function __construct(
		public TestFieldFileElement $file = new TestFieldFileElement()
	) {
	}
}

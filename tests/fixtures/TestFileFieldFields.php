<?php declare(strict_types=1);

namespace MarkIngman\Fields;

class TestFileFieldFields extends Fields
{
	public function __construct(
		public TestFileFieldElement $file = new TestFileFieldElement()
	) {
	}
}

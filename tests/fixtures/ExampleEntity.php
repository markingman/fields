<?php declare(strict_types=1);

namespace MarkIngman\Fields;

readonly class ExampleEntity
{
	public function __construct(
		public string $email = '',
	) {
	}
}


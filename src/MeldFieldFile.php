<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use InvalidArgumentException;
use function is_array;
use function is_int;
use function is_string;
use const UPLOAD_ERR_NO_FILE;

class MeldFieldFile implements MeldFieldInterface
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element, mixed $value): void
	{
		if (!$Element instanceof FieldFileElement) {
			throw new InvalidArgumentException('Expected FieldFileElement');
		}

		if (is_array($value)) {
			$Element->value = [
				'name' => (isset($value['name']) and is_string($value['name'])) ? $value['name'] : null,
				'full_path' => (isset($value['full_path']) and is_string($value['full_path'])) ? $value['full_path'] : null,
				'type' => (isset($value['type']) and is_string($value['type'])) ? $value['type'] : null,
				'tmp_name' => (isset($value['tmp_name']) and is_string($value['tmp_name'])) ? $value['tmp_name'] : null,
				'error' => (isset($value['error']) and is_int($value['error'])) ? $value['error'] : UPLOAD_ERR_NO_FILE,
				'size' => (isset($value['size']) and is_int($value['size'])) ? $value['size'] : null,
			];
		}
	}
}

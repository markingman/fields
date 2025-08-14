<?php declare(strict_types=1);

namespace MarkIngman\Fields;

interface FieldsInterface
{
	public function validate(): bool;

	/** @param array<mixed> $vals */
	public function meld_values(array $vals): void;

	public function is_valid(): bool;

	/** @return array<string> */
	public function get_invalids(): array;

	/**
	 * @param array<string> $exclude
	 * @return array<string, string|array<string>|array{
	 *      name?: string|null,
	 *      full_path?: string|null,
	 *      type?: string|null,
	 *      tmp_name?: string|null,
	 *      error?: int|null,
	 *      size?: int|null
	 *  }|null>
	 */
	public function get_values(array $exclude = []): array;
}

<?php declare(strict_types=1);

namespace MarkIngman\Fields;

interface FieldsInterface
{
	/** @param array<mixed> ...$vals */
	public function meld_values(array ...$vals): void;

	public function validate(): bool;

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

	public function get_property_name(AbstractFieldElement $e): ?string;

	public function get_last_meld_key(AbstractFieldElement $e): ?string;

	public function reset_values(): void;

	public function update_default_values(): void;
}

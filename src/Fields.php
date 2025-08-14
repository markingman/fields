<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use Iterator;
use LogicException;
use ReflectionClass;
use ReflectionProperty;
use function array_key_exists;
use function count;
use function in_array;
use function spl_object_id;

/** @implements Iterator<string, AbstractFieldElement> */
class Fields implements Iterator, FieldsInterface
{
	/** @var array<int, string> $_index */
	private array $_index = [];
	private int $_i = -1;
	/** @var array<int, int> $_oid_index */
	private array $_oid_index = [];
	/** @var array<int, string> $_last_meld_key */
	private array $_last_meld_key = [];

	public function current(): AbstractFieldElement
	{
		$this->_ensure_indexed();

		return $this->{$this->_index[$this->_i]};
	}

	public function next(): void
	{
		$this->_ensure_indexed();

		$this->_i++;
	}

	public function key(): string
	{
		$this->_ensure_indexed();

		return $this->_index[$this->_i];
	}

	public function valid(): bool
	{
		$this->_ensure_indexed();

		return isset($this->_index[$this->_i]);
	}

	public function rewind(): void
	{
		$this->_ensure_indexed();

		$this->_i = 0;
	}

	public function validate(): bool
	{
		foreach ($this as $field) {
			if ($validator = $field->get_validator()) {
				$validator($this, $field);
			}
		}

		return $this->is_valid();
	}

	/** @param array<mixed> $vals */
	public function meld_values(array $vals): void
	{
		$this->_last_meld_key = [];

		foreach ($this as $k => $field) {
			if ($meld = $field->get_meld()) {
				// property name is canonical; alias via $field->name is optional
				$meld_key = match (true) {
					array_key_exists($k, $vals) => $k,
					$field->name !== '' and array_key_exists($field->name, $vals) => $field->name,
					default => null
				};
				if ($meld_key === null) {
					continue;
				}
				$this->_last_meld_key[spl_object_id($field)] = $meld_key;
				$field->reset_value();
				$meld($this, $field, $vals[$meld_key]);
			}
		}
	}

	public function reset_values(): void
	{
		foreach ($this as $field) {
			$field->reset_value();
		}
	}

	public function update_default_values(): void
	{
		foreach ($this as $field) {
			$field->update_default_value();
		}
	}

	public function is_valid(): bool
	{
		foreach ($this as $field) {
			if (!$field->valid) {
				return false;
			}
		}

		return true;
	}

	/** @return array<string> */
	public function get_invalids(): array
	{
		$invalids = [];

		foreach ($this as $name => $field) {
			if (!$field->valid) {
				$invalids[] = $name;
			}
		}

		return $invalids;
	}

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
	public function get_values(array $exclude = []): array
	{
		$values = [];

		foreach ($this as $name => $field) {
			if (!in_array($name, $exclude, true)) {
				$values[$name] = $field->value ?? null;
			}
		}

		return $values;
	}

	public function get_property_name(AbstractFieldElement $e): ?string
	{
		$this->_ensure_indexed();

		return $this->_index[$this->_oid_index[spl_object_id($e)]] ?? null;
	}

	public function get_last_meld_key(AbstractFieldElement $e): ?string
	{
		$this->_ensure_indexed();

		return $this->_last_meld_key[spl_object_id($e)] ?? null;
	}

	private function _ensure_indexed(): void
	{
		if ($this->_i !== -1) {
			return;
		}

		$names = [];
		foreach ((new ReflectionClass($this))->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
			$property_name = $property->getName();
			if ($this->$property_name instanceof AbstractFieldElement) {
				$name = $this->$property_name->name;
				if ($name) {
					if (isset($names[$name])) {
						throw new LogicException("Name collision: '$property_name / $name'");
					}
					$names[$name] = null;
				}
				$this->_index[] = $property_name;

				$this->_oid_index[spl_object_id($this->$property_name)] = count($this->_index) - 1;
			}
		}

		$this->_i = 0;
	}
}

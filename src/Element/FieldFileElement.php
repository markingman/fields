<?php declare(strict_types=1);

namespace MarkIngman\Fields\Element;

use MarkIngman\Fields\FieldErrType;
use MarkIngman\Fields\Meld\MeldFieldFile;
use MarkIngman\Fields\Validate\ValidateFieldFile;
use const UPLOAD_ERR_NO_FILE;

class FieldFileElement extends AbstractFieldElement
{
	/** @var array{
	 * name?: string|null,
	 * full_path?: string|null,
	 * type?: string|null,
	 * tmp_name?: string|null,
	 * error?: int|null,
	 * size?: int|null
	 * } $default
	 */
	public array $default;
	private ?MeldFieldFile $meld = null;
	private ?ValidateFieldFile $validator = null;

	/**
	 * @param array{
	 *     name?: string|null,
	 *     full_path?: string|null,
	 *     type?: string|null,
	 *     tmp_name?: string|null,
	 *     error?: int|null,
	 *     size?: int|null
	 * } $value File upload data array, similar to $_FILES structure:
	 *     - name: Original filename on the client machine.
	 *     - full_path: Full path as sent by the browser (if supported).
	 *     - type: MIME type of the uploaded file.
	 *     - tmp_name: Temporary filename of the file stored on the server.
	 *     - error: Error code associated with the file upload (UPLOAD_ERR_*).
	 *     - size: Size of the uploaded file in bytes.
	 */
	public function __construct(
		string $name = '',
		string $label = '',
		bool $valid = false,
		FieldErrType $err = FieldErrType::ERR_NONE,
		bool $required = false,
		bool $disabled = false,
		bool $display = true,
		public array $value = [
			'name' => null,
			'full_path' => null,
			'type' => null,
			'tmp_name' => null,
			'error' => UPLOAD_ERR_NO_FILE,
			'size' => 0,
		],
		protected int $size_max = 1_048_576,//1MB max upload size
		protected string $mime_type = 'text/plain',//comma string
		protected string $suffix = 'txt',
	) {
		$this->default = $value;

		parent::__construct(
			name: $name,
			label: $label,
			valid: $valid,
			err: $err,
			required: $required,
			disabled: $disabled,
			display: $display,
		);
	}

	public function reset_value(): void
	{
		$this->value = $this->default;
	}

	public function update_default_value(): void
	{
		$this->default = $this->value;
	}

	public function get_value_name(): string
	{
		return $this->value['name'] ?? '';
	}

	public function get_value_full_path(): string
	{
		return $this->value['full_path'] ?? '';
	}

	public function get_value_type(): string
	{
		return $this->value['type'] ?? '';
	}

	public function set_value_type(string $type): void
	{
		$this->value['type'] = $type;
	}

	public function get_value_tmp_name(): string
	{
		return $this->value['tmp_name'] ?? '';
	}

	public function get_value_error(): int
	{
		return $this->value['error'] ?? UPLOAD_ERR_NO_FILE;
	}

	public function get_value_size(): int
	{
		return $this->value['size'] ?? 0;
	}

	public function get_accept_size_max(): int
	{
		return $this->size_max;
	}

	public function get_accept_mime_type(): string
	{
		return $this->mime_type;
	}

	public function get_accept_suffix(): string
	{
		return $this->suffix;
	}

	// TODO: move uploaded file
// 	public function get_uploaded_file(string $to): bool
// 	{
// 		if (!strlen($tmp_name = $this->get_value_tmp_name())) {
// 			throw new RuntimeException('No file found');
// 		}
// 
// 		return $this->move_uploaded_file($tmp_name, $to);
// 	}

	public function get_meld(): MeldFieldFile
	{
		return $this->meld ??= new MeldFieldFile();
	}

	public function get_validator(): ValidateFieldFile
	{
		return $this->validator ??= new ValidateFieldFile();
	}
}

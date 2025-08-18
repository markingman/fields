<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use finfo;
use InvalidArgumentException;
use RuntimeException;
use function explode;
use function finfo_close;
use function finfo_file;
use function finfo_open;
use function is_uploaded_file;
use function rtrim;
use function str_ends_with;
use function str_starts_with;
use function strlen;
use function trim;
use const FILEINFO_MIME_TYPE;
use const FILEINFO_NONE;
use const UPLOAD_ERR_CANT_WRITE;
use const UPLOAD_ERR_EXTENSION;
use const UPLOAD_ERR_FORM_SIZE;
use const UPLOAD_ERR_INI_SIZE;
use const UPLOAD_ERR_NO_TMP_DIR;
use const UPLOAD_ERR_OK;

class ValidateFieldFile implements ValidateFieldInterface
{
	public function __invoke(Fields $Fields, AbstractFieldElement $Element): bool
	{
		if (!($Element instanceof FieldFileElement)) {
			throw new InvalidArgumentException('Expected FieldFileElement');
		}

		$err = match ($Element->get_value_error()) {
			UPLOAD_ERR_OK => FieldErrType::ERR_NONE,
			UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => FieldErrType::ERR_SIZE,
			UPLOAD_ERR_NO_TMP_DIR, UPLOAD_ERR_CANT_WRITE => FieldErrType::ERR_SYSTEM,
			UPLOAD_ERR_EXTENSION => FieldErrType::ERR_TYPE,
			//UPLOAD_ERR_PARTIAL, UPLOAD_ERR_NO_FILE => FieldErrType::ERR_EMPTY,
			default => FieldErrType::ERR_EMPTY,
		};

		if ($err !== FieldErrType::ERR_NONE) {
			$Element->valid = false;
			$Element->err = $err;

			return false;
		}

		if (!$this->is_uploaded_file($Element->get_value_tmp_name())) {
			$Element->valid = false;
			$Element->err = FieldErrType::ERR_SYSTEM;

			return false;
		}

		if ($Element->get_value_size() > $Element->get_accept_size_max()) {
			$Element->valid = false;
			$Element->err = FieldErrType::ERR_SIZE;

			return false;
		}

		if (!$mime_type = $this->validate_mime($Element->get_value_tmp_name(), $Element->get_accept_mime_type())) {
			$Element->valid = false;
			$Element->err = FieldErrType::ERR_TYPE;

			return false;
		} else {
			$Element->set_value_type($mime_type);
		}

		$name = $Element->get_value_name();
		if ($Element->get_accept_suffix() !== '' && $name !== '') {
			if (!str_ends_with(strtolower($name), '.' . strtolower($Element->get_accept_suffix()))) {
				$Element->valid = false;
				$Element->err = FieldErrType::ERR_TYPE;

				return false;
			}
		}

		$Element->valid = true;
		$Element->err = FieldErrType::ERR_NONE;

		return true;
	}

	public function validate_mime(string $file_path, string $allowed_mime_types): string|false
	{
		if (!strlen($allowed_mime_types)) {
			throw new InvalidArgumentException('No mime types to check');
		}

		$finfo = $this->finfo_open(FILEINFO_MIME_TYPE);

		if (!$finfo) {
			throw new RuntimeException('Unable to open fileinfo');
		}

		$mime_type = $this->finfo_file($finfo, $file_path);
		$this->finfo_close($finfo);

		if ($mime_type === false) {
			throw new RuntimeException('Unable to determine the MIME type');
		}

		foreach (explode(',', $allowed_mime_types) as $allowed_mime_type) {
			$allowed_mime_type = trim($allowed_mime_type);
			if (str_ends_with($allowed_mime_type, '/*')) {
				if (str_starts_with($mime_type, rtrim($allowed_mime_type, '/*'))) {
					return $mime_type;
				}
			} elseif ($mime_type === $allowed_mime_type) {
				return $mime_type;
			}
		}

		return false;
	}

	protected function finfo_close(finfo $finfo): bool
	{
		return finfo_close($finfo);
	}

	protected function is_uploaded_file(string $filename): bool
	{
		return is_uploaded_file($filename);
	}

	protected function finfo_open(int $flags = FILEINFO_NONE): finfo|false
	{
		return finfo_open($flags);
	}

	protected function finfo_file(finfo $finfo, string $filename): string|false
	{
		return finfo_file($finfo, $filename);
	}
}

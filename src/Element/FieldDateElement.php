<?php declare(strict_types=1);

namespace MarkIngman\Fields\Element;

use MarkIngman\Fields\Meld\MeldFieldDate;
use MarkIngman\Fields\Validate\ValidateFieldDate;

class FieldDateElement extends FieldTextElement
{
	private ?MeldFieldDate $meld = null;
	private ?ValidateFieldDate $validator = null;

	public function get_meld(): MeldFieldDate
	{
		return $this->meld ??= new MeldFieldDate();
	}

	public function get_validator(): ValidateFieldDate
	{
		return $this->validator ??= new ValidateFieldDate();
	}
}

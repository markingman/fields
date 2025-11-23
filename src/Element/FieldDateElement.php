<?php declare(strict_types=1);

namespace MarkIngman\Fields\Element;

use MarkIngman\Fields\Meld\FieldDateMeld;
use MarkIngman\Fields\Validate\FieldDateValidate;

class FieldDateElement extends FieldTextElement
{
	private ?FieldDateMeld $meld = null;
	private ?FieldDateValidate $validator = null;

	public function get_meld(): FieldDateMeld
	{
		return $this->meld ??= new FieldDateMeld();
	}

	public function get_validator(): FieldDateValidate
	{
		return $this->validator ??= new FieldDateValidate();
	}
}

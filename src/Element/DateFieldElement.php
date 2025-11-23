<?php declare(strict_types=1);

namespace MarkIngman\Fields\Element;

use MarkIngman\Fields\Meld\DateFieldMeld;
use MarkIngman\Fields\Validate\DateFieldValidate;

class DateFieldElement extends TextFieldElement
{
	private ?DateFieldMeld $meld = null;
	private ?DateFieldValidate $validator = null;

	public function get_meld(): DateFieldMeld
	{
		return $this->meld ??= new DateFieldMeld();
	}

	public function get_validator(): DateFieldValidate
	{
		return $this->validator ??= new DateFieldValidate();
	}
}

<?php declare(strict_types=1);

namespace MarkIngman\Fields\Exception;

use LogicException;

class UnexpectedTypeException extends LogicException implements FieldsException
{
}


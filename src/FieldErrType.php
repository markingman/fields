<?php declare(strict_types=1);

namespace MarkIngman\Fields;

enum FieldErrType: int
{
	case ERR_NONE = 0;
	case ERR_EMPTY = 1;
	case ERR_FORMAT = 2;
	case ERR_NOT_FOUND = 3;
	case ERR_NOT_UNIQUE = 4;
	case ERR_SIZE = 5;
	case ERR_SYSTEM = 6;
	case ERR_TYPE = 7;
// 	case ERR_DIMENSION = 8;
}

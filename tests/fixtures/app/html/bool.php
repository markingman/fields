<?php declare(strict_types=1);

use MarkIngman\Fields\TestBoolFields;
use function MarkIngman\Fields\app\handle_request;

handle_request(new TestBoolFields());

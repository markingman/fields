<?php declare(strict_types=1);

use MarkIngman\Fields\TestBoolFields;
use function MarkIngman\Fields\app\handle_post_request;

handle_post_request(new TestBoolFields());

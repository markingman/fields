<?php declare(strict_types=1);

use MarkIngman\Fields\TestDateFields;
use function MarkIngman\Fields\app\handle_post_request;

handle_post_request(new TestDateFields());

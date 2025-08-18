<?php declare(strict_types=1);

use MarkIngman\Fields\TestTextFields;
use function MarkIngman\Fields\app\handle_post_request;

handle_post_request(new TestTextFields());

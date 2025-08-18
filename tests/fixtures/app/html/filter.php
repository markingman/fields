<?php declare(strict_types=1);

use MarkIngman\Fields\TestFilterFields;
use function MarkIngman\Fields\app\is_get;
use function MarkIngman\Fields\app\json_response;
use function MarkIngman\Fields\app\method_not_allowed_response;

$F = new TestFilterFields();

if (is_get()) {
	$F->meld_values($_GET);
	json_response($F->get_values(), 200);
} else {
	method_not_allowed_response();
}

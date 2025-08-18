<?php declare(strict_types=1);

use MarkIngman\Fields\TestEditFields;
use function MarkIngman\Fields\app\handle_post_request;
use function MarkIngman\Fields\app\is_get;
use function MarkIngman\Fields\app\json_response;

$F = new TestEditFields();
$F->meld_values(['id' => '999', 'name' => 'Test', 'email' => 'test@example.com', 'subscribe' => 'yes']);
$F->update_default_values();
$F->id->disabled = true;

if (is_get()) {
	json_response($F->get_values(), 200);
}

handle_post_request($F);

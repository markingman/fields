<?php declare(strict_types=1);

namespace MarkIngman\Fields\app;

use MarkIngman\Fields\Fields;

require_once __DIR__ . '/../../../vendor/autoload.php';

function is_post(): bool
{
	return (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST');
}

function is_get(): bool
{
	return (($_SERVER['REQUEST_METHOD'] ?? '') === 'GET');
}

/** @param array<string, mixed> $values */
function json_response(array $values, int $code = 202): never
{
	$json = json_encode($values);
	if ($json === false) {
		header('Content-Type: application/json', true, 500);
		echo '{"error": "JSON encoding failed: ' . json_last_error_msg() . '"}';
	} else {
		header('Content-Type: application/json', true, $code);
		echo $json;
	}

	exit;
}

function handle_post_request(Fields $F): never
{
	if (is_post()) {
		$F->meld_values($_POST, $_FILES);
		if ($F->validate()) {
			json_response($F->get_values());
		} else {
			json_response(['error' => 'invalid', 'invalid_fields' => $F->get_invalids()], 400);
		}
	}

	method_not_allowed_response();
}

function method_not_allowed_response(): never
{
	json_response(['error' => 'Method not allowed'], 405);
}

$req = $_SERVER['REQUEST_URI'] ?? '';

if (!is_string($req)) {
	http_response_code(400);
	exit('Malformed request');
}

$req = parse_url($req, PHP_URL_PATH);
$root = realpath(__DIR__ . '/..');

$target = match ($req) {
	'/' => __DIR__ . '/html/' . 'index.php',
	'/array' => __DIR__ . '/html/' . 'array.php',
	'/bool' => __DIR__ . '/html/' . 'bool.php',
	'/date' => __DIR__ . '/html/' . 'date.php',
	'/edit' => __DIR__ . '/html/' . 'edit.php',
	'/email' => __DIR__ . '/html/' . 'email.php',
	'/file' => __DIR__ . '/html/' . 'file.php',
	'/filter' => __DIR__ . '/html/' . 'filter.php',
	'/new' => __DIR__ . '/html/' . 'new.php',
	'/text' => __DIR__ . '/html/' . 'text.php',
	default => null,
};

if (!$target || !file_exists($target)) {
	http_response_code(404);
	exit('Route not found' . $req);
}

include $target;

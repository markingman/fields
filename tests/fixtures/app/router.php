<?php declare(strict_types=1);

namespace MarkIngman\Fields\app;

use MarkIngman\Fields\Fields;

require_once __DIR__ . '/../../../vendor/autoload.php';

function is_post(): bool
{
	return (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST');
}

/** @param array<string, mixed> $values */
function json_response(array $values, int $code = 200): never
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

function handle_request(Fields $F): never
{
	if (is_post()) {
		$F->meld_values($_POST, $_FILES);
		if ($F->validate()) {
			json_response($F->get_values());
		} else {
			json_response(['error' => 'invalid', 'invalid_fields' => $F->get_invalids()], 400);
		}
	}

	json_response(['error' => 'Method not allowed'], 405);
}

$req = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
$root = realpath(__DIR__ . '/..');

if (!is_string($req)) {
	http_response_code(400);
	exit('Malformed request');
}

$target = match ($req) {
	'/' => __DIR__ . '/html/' . 'index.php',
	'/array' => __DIR__ . '/html/' . 'array.php',
	'/bool' => __DIR__ . '/html/' . 'bool.php',
	'/date' => __DIR__ . '/html/' . 'date.php',
	'/email' => __DIR__ . '/html/' . 'email.php',
	'/file' => __DIR__ . '/html/' . 'file.php',
	'/text' => __DIR__ . '/html/' . 'text.php',
	default => null,
};

if (!$target || !file_exists($target)) {
	http_response_code(404);
	exit('Route not found');
}

include $target;

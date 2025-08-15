<?php

namespace MarkIngman\Fields;

use PHPUnit\Framework\TestCase;
use function curl_close;
use function curl_errno;
use function curl_error;
use function curl_exec;
use function curl_getinfo;
use function curl_init;
use function curl_setopt_array;
use function json_decode;
use function sprintf;
use const CURLINFO_HTTP_CODE;
use const CURLOPT_CONNECTTIMEOUT;
use const CURLOPT_POST;
use const CURLOPT_POSTFIELDS;
use const CURLOPT_RETURNTRANSFER;
use const CURLOPT_TIMEOUT;
use const CURLOPT_URL;

class TestHTTPClient extends TestCase
{
	/**
	 * @param array<string, mixed> $request
	 * @return array{
	 *   0: int,
	 *   1: array<string, mixed>
	 * }
	 */
	public function request(string $endpoint, array $request): array
	{
		$ch = curl_init();

		curl_setopt_array($ch, [
			CURLOPT_URL => 'http://localhost/' . $endpoint,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $request,
// 			CURLOPT_POSTFIELDS => http_build_query($request),
// 			CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
			CURLOPT_TIMEOUT => 5,
			CURLOPT_CONNECTTIMEOUT => 2,
		]);

		$resp = curl_exec($ch);

		if ($resp === false) {
			$errno = curl_errno($ch);
			$error = curl_error($ch);
			curl_close($ch);
			$this->fail(sprintf('cURL error %d: %s', $errno, $error));
		}

		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		$json = json_decode($resp, true);
		$this->assertIsArray($json, 'Response is not valid JSON');

		return [$code, $json];
	}
}

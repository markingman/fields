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
	public function request(string $endpoint, array $request = [], bool $is_post = true): array
	{
		$ch = curl_init();

		if (!$is_post && $request) {
			$endpoint .= '?' . http_build_query($request);
		}

		curl_setopt_array($ch, [
			CURLOPT_URL => 'http://localhost/' . $endpoint,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => $is_post,
			// not using http_build_query() due to file fields
			// remember manually set nested arrays like `tags[0] => 'a', tags[1] => 'b'` etc.
			CURLOPT_TIMEOUT => 5,
			CURLOPT_CONNECTTIMEOUT => 2,
		]);

		if ($is_post) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		}

		$resp = curl_exec($ch);

		if ($resp === false) {
			$errno = curl_errno($ch);
			$error = curl_error($ch);
			curl_close($ch);
			$this->fail(sprintf('cURL error %d: %s', $errno, $error));
		}

		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		$this->assertIsString($resp, 'Response is not string');

		$json = json_decode($resp, true);
		$this->assertIsArray($json, 'Response is not valid JSON');

		foreach (array_keys($json) as $key) {
			$this->assertIsString($key, 'Top-level JSON must be an object');
		}

		/** @var array<string, mixed> $json */

		return [$code, $json];
	}
}

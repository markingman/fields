<?php

namespace MarkIngman\Fields;

use PHPUnit\Framework\TestCase;
use function curl_file_create;
use function file_put_contents;
use function is_file;
use function sys_get_temp_dir;
use function tempnam;
use function unlink;

final class FileFieldsTest extends TestCase
{
	protected TestHTTPClient $client;
	protected string $textFile;

	public function setUp(): void
	{
		$this->client = new TestHTTPClient('testHTTPClient');
		$this->textFile = $this->createTextFile();
	}

	public function tearDown(): void
	{
		if (is_file($this->textFile)) {
			unlink($this->textFile);
		}
	}

	public function testPostFile(): void
	{
		$ret = $this->client->request('file', [
			'file' => curl_file_create($this->textFile, 'text/plain', 'test.txt')
		]);

		$this->assertArrayHasKey(0, $ret);
		$this->assertEquals(202, $ret[0]);

		$this->assertArrayHasKey(1, $ret);
		$this->assertArrayHasKey('file', $ret[1]);
		$this->assertIsArray($ret[1]['file']);
		$this->assertArrayHasKey('tmp_name', $ret[1]['file']);
		$this->assertIsString($ret[1]['file']['tmp_name']);
		$this->assertMatchesRegularExpression('#^/tmp/php[a-zA-Z0-9]+$#', $ret[1]['file']['tmp_name']);

		unset($ret[1]['file']['tmp_name']);
		$this->assertSame([
			202,
			[
				'file' => [
					'name' => 'test.txt',
					'full_path' => 'test.txt',
					'type' => 'text/plain',
					'error' => 0,
					'size' => 6,
				]
			]
		], $ret);
	}

	protected function createTextFile(): string
	{
		$tmpfname = tempnam(sys_get_temp_dir(), 'text');
		if (!file_put_contents($tmpfname, "Test.\n")) {
			$this->fail('Could not create test text file');
		}

		return $tmpfname;
	}
}

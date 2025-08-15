<?php

namespace MarkIngman\Fields;

use PHPUnit\Framework\TestCase;

final class FieldsArrayTest extends TestCase
{
	protected TestHTTPClient $client;

	public function setUp(): void
	{
		$this->client = new TestHTTPClient('testHTTPClient');
	}

	public function testPostValues(): void
	{
		// TestHTTPClient doesn't use http_build_query(), so passing arrays as item[n] format

		$this->assertEquals([200, ['tags' => ['one', 'two']]], $this->client->request('array', [
			'tags[0]' => 'one',
			'tags[1]' => 'two'
		]));
		$this->assertEquals([200, ['tags' => ['one', 'two', 'three']]], $this->client->request('array', [
			'tags[0]' => 'one',
			'tags[1]' => 'two',
			'tags[2]' => 'two',
			'tags[3]' => 'three'
		]));
		$this->assertEquals([200, ['tags' => ['a']]], $this->client->request('array', [
			'tags[0]' => 'bbbbbb',
			'tags[1]' => 'a'
		]));
	}
}

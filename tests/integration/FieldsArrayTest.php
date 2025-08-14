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
		$this->assertEquals([200, ['tags' => ['one', 'two']]], $this->client->request('array', ['tags' => ['one', 'two']]));
		$this->assertEquals([200, ['tags' => ['one', 'two', 'three']]], $this->client->request('array', ['tags' => ['one', 'two', 'two', 'three']]));
		$this->assertEquals([200, ['tags' => ['a']]], $this->client->request('array', ['tags' => ['bbbbbb', 'a']]));
	}
}

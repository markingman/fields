<?php

namespace MarkIngman\Fields;

use PHPUnit\Framework\TestCase;

final class FieldsTextTest extends TestCase
{
	protected TestHTTPClient $client;

	public function setUp(): void
	{
		$this->client = new TestHTTPClient('testHTTPClient');
	}

	public function testPostValues(): void
	{
		$this->assertEquals([202, ['text' => 'test']], $this->client->request('text', ['t' => 'test']));
		$this->assertEquals([202, ['text' => 'update']], $this->client->request('text', ['t' => 'update']));
	}
}

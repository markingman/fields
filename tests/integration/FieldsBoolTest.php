<?php

namespace MarkIngman\Fields;

use PHPUnit\Framework\TestCase;

final class FieldsBoolTest extends TestCase
{
	protected TestHTTPClient $client;

	public function setUp(): void
	{
		$this->client = new TestHTTPClient('testHTTPClient');
	}

	public function testPostValues(): void
	{
		$this->assertEquals([202, ['flag' => 'on']], $this->client->request('bool', ['flag' => 'on']));
		$this->assertEquals([202, ['flag' => '']], $this->client->request('bool', ['flag' => '']));
		$this->assertEquals([202, ['flag' => '']], $this->client->request('bool', ['flag' => 'off']));
	}
}

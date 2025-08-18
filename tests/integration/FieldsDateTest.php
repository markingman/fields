<?php

namespace MarkIngman\Fields;

use PHPUnit\Framework\TestCase;

final class FieldsDateTest extends TestCase
{
	protected TestHTTPClient $client;

	public function setUp(): void
	{
		$this->client = new TestHTTPClient('testHTTPClient');
	}

	public function testPostValues(): void
	{
		$this->assertEquals([202, ['date' => '1980-01-01']], $this->client->request('date', ['date' => '1980-01-01']));
		$this->assertEquals([202, ['date' => '1990-01-01']], $this->client->request('date', ['d' => '1990-01-01']));
		$this->assertEquals([400, ['error' => 'invalid', 'invalid_fields' => ['date']]], $this->client->request('date', ['d' => '1990-02-30']));
	}
}

<?php

namespace MarkIngman\Fields;

use PHPUnit\Framework\TestCase;

final class FieldsEmailTest extends TestCase
{
	protected TestHTTPClient $client;

	public function setUp(): void
	{
		$this->client = new TestHTTPClient('testHTTPClient');
	}

	public function testPostValues(): void
	{
		$this->assertEquals([202, ['email' => 'test@example.com']], $this->client->request('email', ['email' => 'test@example.com']));
		$this->assertEquals([202, ['email' => 'update@example.com']], $this->client->request('email', ['e' => 'update@example.com']));
		$this->assertEquals([400, ['error' => 'invalid', 'invalid_fields' => ['email']]], $this->client->request('email', ['e' => '-']));
	}
}

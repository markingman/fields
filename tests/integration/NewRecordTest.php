<?php

namespace MarkIngman\Fields;

use PHPUnit\Framework\TestCase;

final class NewRecordTest extends TestCase
{
	protected TestHTTPClient $client;

	public function setUp(): void
	{
		$this->client = new TestHTTPClient('testHTTPClient');
	}

	public function testGetValues(): void
	{
		$this->assertEquals(
			[200, ['id' => '0', 'name' => '', 'email' => '', 'subscribe' => '']],
			$this->client->request('new', is_post: false)
		);

		$this->assertEquals(
			[202, ['id' => '0', 'name' => 'Test', 'email' => 'test@example.com', 'subscribe' => 'yes']],
			$this->client->request('new', ['id' => '999', 'name' => 'Test', 'email' => 'test@example.com', 'subscribe' => 'yes'])
		);
	}
}

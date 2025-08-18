<?php

namespace MarkIngman\Fields;

use PHPUnit\Framework\TestCase;

final class EditRecordTest extends TestCase
{
	protected TestHTTPClient $client;

	public function setUp(): void
	{
		$this->client = new TestHTTPClient('testHTTPClient');
	}

	public function testGetValues(): void
	{
		$this->assertEquals(
			[200, ['id' => '999', 'name' => 'Test', 'email' => 'test@example.com', 'subscribe' => 'yes']],
			$this->client->request('edit', is_post: false)
		);
	}

	public function testPostValues(): void
	{
		$this->assertEquals(
			[202, ['id' => '999', 'name' => 'Update', 'email' => 'update@example.com', 'subscribe' => '']],
			$this->client->request('edit', ['id' => '777', 'name' => 'Update', 'email' => 'update@example.com', 'subscribe' => ''])
		);
	}
}

<?php

namespace MarkIngman\Fields;

use PHPUnit\Framework\TestCase;

final class FilterTest extends TestCase
{
	protected TestHTTPClient $client;

	public function setUp(): void
	{
		$this->client = new TestHTTPClient('testHTTPClient');
	}

	public function testGetValues(): void
	{
		$this->assertEquals(
			[200, ['query' => 'test', 'status' => 'a', 'types' => ['b', 'c']]],
			$this->client->request('filter', ['q' => 'test', 's' => 'a', 't' => ['b', 'c']], is_post: false)
		);

		$this->assertEquals(
			[200, ['query' => '', 'status' => '', 'types' => ['']]],
			$this->client->request('filter', ['q' => 'test1234', 's' => 'x', 't' => ['a', 'b', 'c', 'd']], is_post: false)
		);
	}
}

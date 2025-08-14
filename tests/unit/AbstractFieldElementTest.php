<?php declare(strict_types=1);

namespace MarkIngman\Fields;

use PHPUnit\Framework\TestCase;

final class AbstractFieldElementTest extends TestCase
{
	public function testCreate(): void
	{
		$this->assertInstanceOf(AbstractFieldElement::class, $this->getCustomFieldElement());
	}

	public function testUnsetMeld(): void
	{
		$A = $this->getCustomFieldElement();

		$this->assertNull($A->get_meld());
	}

	public function testUnsetValidator(): void
	{
		$A = $this->getCustomFieldElement();

		$this->assertNull($A->get_validator());
	}

	private function getCustomFieldElement(): AbstractFieldElement
	{
		return new class extends AbstractFieldElement {
			public function __construct()
			{
				parent::__construct();
			}

			public function reset_value(): void
			{
			}

			public function update_default_value(): void
			{
			}
		};
	}
}

<?php
use PHPUnit\Framework\TestCase;

class InitialGenerationTest extends TestCase
{
	public function testInitialsAreGeneratedFromFullname()
	{
		// Arrange
		$a = new Money(1);

		// Act
		$b = $a->negate();

		// Assert
		$this->assertEquals(-1, $b->getAmount());
	}
}
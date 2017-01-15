<?php

use PHPUnit\Framework\TestCase;
use LasseRafn\InitialAvatarGenerator\InitialAvatar;

class InitialGenerationTest extends TestCase
{
	public function testInitialsAreGeneratedFromFullname()
	{
		$avatar = new InitialAvatar();

		// Two names

		$avatar->name('John Doe');

		$this->assertEquals('JD', $avatar->getParameterName());

		// Single name

		$avatar->name('John');

		$this->assertEquals('JO', $avatar->getParameterName());

		// Initials

		$avatar->name('MA');

		$this->assertEquals('MA', $avatar->getParameterName());

		// Three names

		$avatar->name('John Doe Bergerson');

		$this->assertEquals('JB', $avatar->getParameterName());

		// Other name

		$avatar->name('Gustav Årgonson');

		$this->assertEquals('GÅ', $avatar->getParameterName());

		$avatar->name('Chanel Butterman');

		$this->assertNotEquals('AB', $avatar->getParameterName());
		$this->assertEquals('CB', $avatar->getParameterName());
	}
}
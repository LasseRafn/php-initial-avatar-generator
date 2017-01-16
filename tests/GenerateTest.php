<?php

use PHPUnit\Framework\TestCase;
use LasseRafn\InitialAvatarGenerator\InitialAvatar;

class GenerateTest extends TestCase
{
	public function testCanGenerateInitialsWithoutNameParameter()
	{
		$avatar = new InitialAvatar();

		$avatar->generate( 'Lasse Rafn' );

		$this->assertEquals( 'LR', $avatar->getInitials() );
	}

	public function testReturnsImageObject()
	{
		$avatar = new InitialAvatar();

		$image = $avatar->generate();

		$this->assertEquals( 'Image', class_basename( $image ) );
	}

	public function testStreamIsReadable()
	{
		$avatar = new InitialAvatar();

		$this->assertTrue( $avatar->generate()->stream()->isReadable() );
	}
}
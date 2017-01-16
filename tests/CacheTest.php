<?php

use PHPUnit\Framework\TestCase;
use LasseRafn\InitialAvatarGenerator\InitialAvatar;

class CacheTest extends TestCase
{
	public function testIsCached()
	{
		$avatar = new InitialAvatar();

		$avatar->cache( 60 );

		$this->assertEquals( 'CachedImage', class_basename( $avatar->generate() ) );
	}

	public function testIsNotCached()
	{
		$avatar = new InitialAvatar();

		$this->assertEquals( 'Image', class_basename( $avatar->generate() ) );
	}
}
<?php

use LasseRafn\InitialAvatarGenerator\InitialAvatar;
use PHPUnit\Framework\TestCase;

class CacheTest extends TestCase
{
    public function testIsCached()
    {
        $avatar = new InitialAvatar();

        $avatar->cache(60);
	    $avatar->generate(); // To generate initial cache

        $this->assertEquals('CachedImage', class_basename($avatar->generate()));
    }

    public function testIsNotCached()
    {
        $avatar = new InitialAvatar();

        $this->assertEquals('Image', class_basename($avatar->generate()));
    }
}

<?php

use LasseRafn\InitialAvatarGenerator\InitialAvatar;
use PHPUnit\Framework\TestCase;

class ImageSizeTest extends TestCase
{
    public function testImageSizeCanBeSet()
    {
        $avatar = new InitialAvatar();

        // 50x50

        $avatar->size(50);

        $this->assertEquals(50, $avatar->generate()->getWidth());
        $this->assertEquals(50, $avatar->generate()->getHeight());

        // 100

        $avatar->size(100);

        $this->assertEquals(100, $avatar->generate()->getWidth());
        $this->assertEquals(100, $avatar->generate()->getHeight());
    }
}

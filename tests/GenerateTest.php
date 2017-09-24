<?php

use LasseRafn\InitialAvatarGenerator\InitialAvatar;
use PHPUnit\Framework\TestCase;

class GenerateTest extends TestCase
{
    public function testCanGenerateInitialsWithoutNameParameter()
    {
        $avatar = new InitialAvatar();

        $avatar->generate('Lasse Rafn');

        $this->assertEquals('LR', $avatar->getInitials());
    }

    public function testReturnsImageObject()
    {
        // Typical
        $avatar = new InitialAvatar();

        $image = $avatar->generate();

        $this->assertEquals('Image', class_basename($image));

        // With emoji
        $avatar = new InitialAvatar();

        $image = $avatar->generate('😅');

        $this->assertEquals('Image', class_basename($image));

        // With Japanese letters
        $avatar = new InitialAvatar();

        $image = $avatar->font('/fonts/NotoSans-Medium.otf')->generate('こんにちは');

        $this->assertEquals('Image', class_basename($image));
    }

    public function testCanMakeARoundedImageObject()
    {
        $avatar = new InitialAvatar();

        $image = $avatar->rounded()->generate();

        $this->assertEquals('Image', class_basename($image));
    }

    public function testCanMakeASmoothRoundedImageObject()
    {
        $avatar = new InitialAvatar();

        $image = $avatar->rounded()->smooth()->generate();

        $this->assertEquals('Image', class_basename($image));
    }

    public function testStreamIsReadable()
    {
        $avatar = new InitialAvatar();

        $this->assertTrue($avatar->generate()->stream()->isReadable());
    }
}

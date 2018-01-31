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

        $this->assertEquals('Intervention\Image\Image', get_class($image));

        // With emoji
        $avatar = new InitialAvatar();

        $image = $avatar->generate('😅');

        $this->assertEquals('Intervention\Image\Image', get_class($image));

        // With Japanese letters
        $avatar = new InitialAvatar();

        $image = $avatar->font(__DIR__.'/fonts/NotoSans-Regular.otf')->generate('こんにちは');

        $this->assertEquals('Intervention\Image\Image', get_class($image));

        // With GD font
        $avatar = new InitialAvatar();

        $image = $avatar->font(2)->generate('LR');

        $this->assertEquals('Intervention\Image\Image', get_class($image));
        $this->assertTrue($image->stream()->isReadable());
    }

    public function testCanMakeARoundedImageObject()
    {
        $avatar = new InitialAvatar();

        $image = $avatar->rounded()->generate();

        $this->assertEquals('Intervention\Image\Image', get_class($image));
    }

    public function testCanMakeASmoothRoundedImageObject()
    {
        $avatar = new InitialAvatar();

        $image = $avatar->rounded()->smooth()->generate();

        $this->assertEquals('Intervention\Image\Image', get_class($image));
    }

    public function testStreamIsReadable()
    {
        $avatar = new InitialAvatar();

        $this->assertTrue($avatar->generate()->stream()->isReadable());
    }

    public function testWithSpecifiedLocalFont()
    {
        $avatar = new InitialAvatar();

        $image = $avatar->font(__DIR__.'/fonts/NotoSans-Regular.ttf')->generate();

        $this->assertEquals('Intervention\Image\Image', get_class($image));
    }

    public function testWithFontFallback()
    {
        $avatar = new InitialAvatar();

        $image = $avatar->font('no-font')->generate();

        $this->assertEquals('Intervention\Image\Image', get_class($image));
    }

    public function testFontWithoutSlash()
    {
        $avatar = new InitialAvatar();

        $image = $avatar->font('fonts/NotoSans-Regular.ttf')->generate();

        $this->assertEquals('Intervention\Image\Image', get_class($image));
    }
}

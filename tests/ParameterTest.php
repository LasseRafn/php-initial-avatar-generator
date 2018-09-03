<?php

use LasseRafn\InitialAvatarGenerator\InitialAvatar;
use PHPUnit\Framework\TestCase;

class ParameterTest extends TestCase
{
    public function testCanSetBackgroundColor()
    {
        $avatar = new InitialAvatar();

        $avatar->background('#000');

        $this->assertEquals('#000', $avatar->getBackgroundColor());

        $avatar->background('#fff');

        $this->assertEquals('#fff', $avatar->getBackgroundColor());
    }

    public function testCanSetFontColor()
    {
        $avatar = new InitialAvatar();

        $avatar->color('#000');

        $this->assertEquals('#000', $avatar->getColor());

        $avatar->color('#fff');

        $this->assertEquals('#fff', $avatar->getColor());
    }

    public function testCanSetFontSize()
    {
        $avatar = new InitialAvatar();

        $avatar->fontSize(0.3);

        $this->assertEquals('0.3', $avatar->getFontSize()); // Had to use strings as floats in PHP are nasty..

        $avatar->fontSize(0.7);

        $this->assertEquals('0.7', $avatar->getFontSize()); // Had to use strings as floats in PHP are nasty..
    }

    public function testCanSetFont()
    {
        $avatar = new InitialAvatar();

        $avatar->font('/fonts/OpenSans-Semibold.ttf');

        $this->assertEquals('/fonts/OpenSans-Semibold.ttf', $avatar->getFontFile());
    }

    public function testCanSetRounded()
    {
        $avatar = new InitialAvatar();

        $avatar->rounded();

        $this->assertTrue($avatar->getRounded());

        $avatar->rounded(false);

        $this->assertNotTrue($avatar->getRounded());
    }

    public function testCanSetSmooth()
    {
        $avatar = new InitialAvatar();

        $avatar->smooth();

        $this->assertTrue($avatar->getSmooth());

        $avatar->smooth(false);

        $this->assertNotTrue($avatar->getSmooth());
    }

    public function testCanSetAutoFont()
    {
        $avatar = new InitialAvatar();

        $avatar->autoFont();

        $this->assertTrue($avatar->getAutoFont());

        $avatar->autoFont(false);

        $this->assertNotTrue($avatar->getAutoFont());
    }
}

<?php

use LasseRafn\InitialAvatarGenerator\InitialAvatar;
use PHPUnit\Framework\TestCase;

class ParameterTest extends TestCase
{
    public function testCanSetBackgroundColor()
    {
        $avatar = new InitialAvatar();

        $avatar->background('#000');

        $this->assertEquals('#000', $avatar->getParameterBackgroundColor());

        $avatar->background('#fff');

        $this->assertEquals('#fff', $avatar->getParameterBackgroundColor());
    }

    public function testCanSetFontColor()
    {
        $avatar = new InitialAvatar();

        $avatar->color('#000');

        $this->assertEquals('#000', $avatar->getParameterColor());

        $avatar->color('#fff');

        $this->assertEquals('#fff', $avatar->getParameterColor());
    }

    public function testCanSetFontSize()
    {
        $avatar = new InitialAvatar();

        $avatar->fontSize(0.3);

        $this->assertEquals('0.3', $avatar->getParameterFontSize()); // Had to use strings as floats in PHP are nasty..

        $avatar->fontSize(0.7);

        $this->assertEquals('0.7', $avatar->getParameterFontSize()); // Had to use strings as floats in PHP are nasty..
    }

    public function testCanSetFont()
    {
        $avatar = new InitialAvatar();

        $avatar->font('/fonts/OpenSans-Semibold.ttf');

        $this->assertEquals('/fonts/OpenSans-Semibold.ttf', $avatar->getParameterFontFile());
    }

    public function testCanSetRounded()
    {
        $avatar = new InitialAvatar();

        $avatar->rounded();

        $this->assertTrue($avatar->getParameterRounded());

        $avatar->rounded(false);

        $this->assertNotTrue($avatar->getParameterRounded());
    }

    public function testCanSetSmooth()
    {
        $avatar = new InitialAvatar();

        $avatar->smooth();

        $this->assertTrue($avatar->getParameterSmooth());

        $avatar->smooth(false);

        $this->assertNotTrue($avatar->getParameterSmooth());
    }

    public function testCanSetAutoFont()
    {
        $avatar = new InitialAvatar();

        $avatar->autoFont();

        $this->assertTrue($avatar->getParameterAutoFont());

        $avatar->autoFont(false);

        $this->assertNotTrue($avatar->getParameterAutoFont());
    }
}

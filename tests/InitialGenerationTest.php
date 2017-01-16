<?php

use LasseRafn\InitialAvatarGenerator\InitialAvatar;
use PHPUnit\Framework\TestCase;

class InitialGenerationTest extends TestCase
{
    public function testInitialsAreGeneratedFromFullname()
    {
        $avatar = new InitialAvatar();

        // Two names

        $avatar->name('John Doe');

        $this->assertEquals('JD', $avatar->getInitials());

        // Single name

        $avatar->name('John');

        $this->assertEquals('JO', $avatar->getInitials());

        // Initials

        $avatar->name('MA');

        $this->assertEquals('MA', $avatar->getInitials());

        // Three names

        $avatar->name('John Doe Bergerson');

        $this->assertEquals('JB', $avatar->getInitials());

        // Other name

        $avatar->name('Gustav Årgonson');

        $this->assertEquals('GÅ', $avatar->getInitials());

        $avatar->name('Chanel Butterman');

        $this->assertNotEquals('AB', $avatar->getInitials());
        $this->assertEquals('CB', $avatar->getInitials());
    }
}

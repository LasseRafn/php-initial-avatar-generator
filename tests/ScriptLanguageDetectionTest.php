<?php

use LasseRafn\InitialAvatarGenerator\InitialAvatar;
use PHPUnit\Framework\TestCase;

class ScriptLanguageDetectionTest extends TestCase
{
    public function testCanDetectScriptLanguagesAndUseThem()
    {
        $avatar = new InitialAvatar();

        $image = $avatar->autoFont()->generate('الحزمة');

        $this->assertEquals('Image', class_basename($image));
        $this->assertTrue($image->stream()->isReadable());
    }
}

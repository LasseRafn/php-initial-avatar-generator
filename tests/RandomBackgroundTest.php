<?php

use LasseRafn\InitialAvatarGenerator\InitialAvatar;
use PHPUnit\Framework\TestCase;

class RandomBackgroundTest extends TestCase
{
    /** @test */
    public function it_generates_random_background_colors()
    {
        $avatar = new InitialAvatar();
        $avatar->randomBackground(true);
        
        // Verify random background is enabled
        $this->assertTrue($avatar->getRandomBackgroundColor());
        
        // Get first color
        $firstColor = $avatar->getBackgroundColor();
        
        // Get second color - should be different
        $secondColor = $avatar->getBackgroundColor();
        
        // Colors should be different due to random generation
        $this->assertNotEquals($firstColor, $secondColor);
        
        // Disable random background
        $avatar->randomBackground(false);
        $this->assertFalse($avatar->getRandomBackgroundColor());
        
        // Set fixed background
        $fixedColor = '#123456';
        $avatar->background($fixedColor);
        
        // Get color multiple times - should be the same
        $this->assertEquals($fixedColor, $avatar->getBackgroundColor());
        $this->assertEquals($fixedColor, $avatar->getBackgroundColor());
    }
    
    /** @test */
    public function it_generates_different_avatars_with_random_background()
    {
        $avatar = new InitialAvatar();
        $avatar->randomBackground(true);
        
        // Generate two avatars
        $firstAvatar = $avatar->generate('Test User');
        $firstBgColor = $avatar->getBackgroundColor();
        
        $secondAvatar = $avatar->generate('Test User');
        $secondBgColor = $avatar->getBackgroundColor();
        
        // Background colors should be different
        $this->assertNotEquals($firstBgColor, $secondBgColor);
        
        // SVG test
        $avatar = new InitialAvatar();
        $avatar->randomBackground(true);
        
        // Generate two SVG avatars
        $firstSvg = $avatar->generateSvg('Test User');
        $firstSvgBgColor = $avatar->getBackgroundColor();
        
        $secondSvg = $avatar->generateSvg('Test User');
        $secondSvgBgColor = $avatar->getBackgroundColor();
        
        // Background colors should be different
        $this->assertNotEquals($firstSvgBgColor, $secondSvgBgColor);
    }
}
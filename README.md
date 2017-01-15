# Generate avatars with initials
Ever seen those avatars (basically everywhere) that has your initials — mine would be LR; Lasse Rafn — well this package allows you to generate those, in a simple manner.

It's framework agnostic, which is different from basically everything else I do, you're welcome.

<p align="center">
<a href="https://travis-ci.org/LasseRafn/php-initial-avatar-generator"><img src="https://travis-ci.org/LasseRafn/php-initial-avatar-generator.svg" alt="Build Status"></a>

<a href="https://packagist.org/packages/LasseRafn/php-initial-avatar-generator"><img src="https://poser.pugx.org/LasseRafn/php-initial-avatar-generator/d/total.svg" alt="Total Downloads"></a>

<a href="https://packagist.org/packages/LasseRafn/php-initial-avatar-generator"><img src="https://poser.pugx.org/LasseRafn/php-initial-avatar-generator/v/stable.svg" alt="Latest Stable Version"></a>

<a href="https://packagist.org/packages/LasseRafn/php-initial-avatar-generator"><img src="https://poser.pugx.org/LasseRafn/php-initial-avatar-generator/license.svg" alt="License"></a>
</p>

## Installation
You just require using composer and you're good to go!
````bash
composer require lasserafn/php-initial-avatar-generator
````

Rad, *and long*, package name.. huh? Sorry. I'm not very good with names.

## Usage
As with installation, usage is quite simple. Generating a image is done by running:
````php
$avatar = new LasseRafn\InitialAvatarGenerator\InitialAvatar();

$image = $avatar->generate('Lasse Rafn'); // Will automatically generate initials
// or
$image = $avatar->name('Lasse Rafn')->generate();
````

Thats it! The method will return a instance of [Image from Intervention](https://github.com/Intervention/image) so you can stream, download or even encode the image:
````php
return $image->stream('png', 100);
````
You can also just pass along the initials, and it will use those. Should you just include a first name, it will use the first two letters of it.

## Supported methods and parameters
Of cause, passing a name is not the only thing this sweet thing does!

### Name (initials) - default: JD
````php
$image = $avatar->name('Albert Magnum')->generate();
````

### Size - default: 48
````php
// will be 96x96 pixels.
$image = $avatar->size(96)->generate();
````

### Background color - default: #000
````php
// will be red
$image = $avatar->background('#ff0000')->generate();
````

### Font color - default: #fff
````php
// will be red
$image = $avatar->color('#ff0000')->generate();
````

### Font file - default: /fonts/OpenSans-Regular.ttf
Two fonts are included:
* /fonts/OpenSans-Regular.ttf
* /fonts/OpenSans-Semibold.ttf

The method automatically appends __DIR__ to it, so the font will be: ````__DIR__ . '/fonts/OpenSans-Regular.ttf'````

````php
// will be Semibold
$image = $avatar->font('/fonts/OpenSans-Semibold.ttf')->generate();
````

### Cache - default: 0 = no cache
Will use **intervention/imagecache** to cache the result.
````php
$image = $avatar->cache()->generate(); // 60 minutes
````
You can simply use ->cache() and it will set cache to 60 minutes, but you can also say ->cache(180) to cache for 180 minutes.

## Chaining it all together
We will not use the ->font() method in this example; as I like the regular one.

````php
return $avatar->name('Lasse Rafn')
              ->size(96) // 48 * 2
              ->background('#8BC34A')
              ->color('#fff')
              ->cache()
              ->generate()
              ->stream('png', 100);
````

Now, using that in a image (sized 48x48 pixels for retina):
````html
<img src="url-for-avatar-generation" width="48" height="48" />
````
Will yield:

<img src="https://raw.githubusercontent.com/LasseRafn/php-initial-avatar-generator/master/demo_result.png" width="48" height="48" alt="Result" />

## Tests
The amount of tests are limited to:
* Testing if 



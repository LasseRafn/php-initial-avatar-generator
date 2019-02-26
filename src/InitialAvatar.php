<?php

namespace LasseRafn\InitialAvatarGenerator;

use Intervention\Image\AbstractFont;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use LasseRafn\InitialAvatarGenerator\Translator\Base;
use LasseRafn\InitialAvatarGenerator\Translator\En;
use LasseRafn\InitialAvatarGenerator\Translator\ZhCN;
use LasseRafn\Initials\Initials;
use LasseRafn\StringScript;

class InitialAvatar
{
	/** @var ImageManager */
	protected $image;

	/** @var Initials */
	protected $initials_generator;

	protected $driver             = 'gd'; // imagick or gd
	protected $fontSize           = 0.5;
	protected $name               = 'John Doe';
	protected $size               = 48;
	protected $bgColor            = '#000';
	protected $fontColor          = '#fff';
	protected $rounded            = false;
	protected $smooth             = false;
	protected $autofont           = false;
	protected $keepCase           = false;
	protected $fontFile           = '/fonts/OpenSans-Regular.ttf';
	protected $generated_initials = 'JD';
	protected $preferBold         = false;

	/**
	 * Language eg.en zh-CN
	 *
	 * @var string
	 */
	protected $language = 'en';

	/**
	 * Role translator
	 *
	 * @var Base
	 */
	protected $translator;

	/**
	 * Language related to translator
	 *
	 * @var array
	 */
	protected $translatorMap = [
		'en'    => En::class,
		'zh-CN' => ZhCN::class,
	];

	public function __construct() {
		$this->setupImageManager();
		$this->initials_generator = new Initials();
	}

	/**
	 * Create a ImageManager instance
	 */
	protected function setupImageManager() {
		$this->image = new ImageManager( [ 'driver' => $this->getDriver() ] );
	}

	/**
	 * Set the name used for generating initials.
	 *
	 * @param string $nameOrInitials
	 *
	 * @return $this
	 */
	public function name( $nameOrInitials ) {
		$nameOrInitials = $this->translate( $nameOrInitials );
		$this->name     = $nameOrInitials;
		$this->initials_generator->name( $nameOrInitials );

		return $this;
	}

	/**
	 * Transforms a unicode string to the proper format
	 *
	 * @param string $char the code to be converted (e.g., f007 would mean the "user" symbol)
	 *
	 * @return $this
	 */
	public function glyph( $char ) {
		$uChar = json_decode( sprintf( '"\u%s"', $char ) );
		$this->name( $uChar );

		return $this;
	}

	/**
	 * Set the length of the generated initials.
	 *
	 * @param int $length
	 *
	 * @return $this
	 */
	public function length( $length = 2 ) {
		$this->initials_generator->length( $length );

		return $this;
	}

	/**
	 * Set time avatar/image size in pixels.
	 *
	 * @param int $size
	 *
	 * @return $this
	 */
	public function size( $size ) {
		$this->size = (int) $size;

		return $this;
	}

	/**
	 * Prefer bold fonts (if possible)
	 *
	 * @return $this
	 */
	public function preferBold() {
		$this->preferBold = true;

		return $this;
	}

	/**
	 * Prefer regular fonts (if possible)
	 *
	 * @return $this
	 */
	public function preferRegular() {
		$this->preferBold = false;

		return $this;
	}

	/**
	 * Set the background color.
	 *
	 * @param string $background
	 *
	 * @return $this
	 */
	public function background( $background ) {
		$this->bgColor = (string) $background;

		return $this;
	}

	/**
	 * Set the font color.
	 *
	 * @param string $color
	 *
	 * @return $this
	 */
	public function color( $color ) {
		$this->fontColor = (string) $color;

		return $this;
	}

	/**
	 * Set the font file by path or int (1-5).
	 *
	 * @param string|int $font
	 *
	 * @return $this
	 */
	public function font( $font ) {
		$this->fontFile = $font;

		return $this;
	}

	/**
	 * Use imagick as the driver.
	 *
	 * @return $this
	 */
	public function imagick() {
		$this->driver = 'imagick';

		$this->setupImageManager();

		return $this;
	}

	/**
	 * Use GD as the driver.
	 *
	 * @return $this
	 */
	public function gd() {
		$this->driver = 'gd';

		$this->setupImageManager();

		return $this;
	}

	/**
	 * Set if should make a round image or not.
	 *
	 * @param bool $rounded
	 *
	 * @return $this
	 */
	public function rounded( $rounded = true ) {
		$this->rounded = (bool) $rounded;

		return $this;
	}

	/**
	 * Set if should detect character script
	 * and use a font that supports it.
	 *
	 * @param bool $autofont
	 *
	 * @return $this
	 */
	public function autoFont( $autofont = true ) {
		$this->autofont = (bool) $autofont;

		return $this;
	}

	/**
	 * Set if should make a rounding smoother with a resizing hack.
	 *
	 * @param bool $smooth
	 *
	 * @return $this
	 */
	public function smooth( $smooth = true ) {
		$this->smooth = (bool) $smooth;

		return $this;
	}

	/**
	 * Set if should skip uppercasing the name.
	 *
	 * @param bool $keepCase
	 *
	 * @return $this
	 */
	public function keepCase( $keepCase = true ) {
		$this->keepCase = (bool) $keepCase;

		return $this;
	}

	/**
	 * Set the font size in percentage
	 * (0.1 = 10%).
	 *
	 * @param float $size
	 *
	 * @return $this
	 */
	public function fontSize( $size = 0.5 ) {
		$this->fontSize = number_format( $size, 2 );

		return $this;
	}

	/**
	 * Generate the image.
	 *
	 * @param null|string $name
	 *
	 * @return Image
	 */
	public function generate( $name = null ) {
		if ( $name !== null ) {
			$this->name               = $name;
			$this->generated_initials = $this->initials_generator->keepCase( $this->getKeepCase() )->generate( $name );
		}

		return $this->makeAvatar( $this->image );
	}

	/**
	 * Will return the generated initials.
	 *
	 * @return string
	 */
	public function getInitials() {
		return $this->initials_generator->keepCase( $this->getKeepCase() )->name( $this->name )->getInitials();
	}

	/**
	 * Will return the background color parameter.
	 *
	 * @return string
	 */
	public function getBackgroundColor() {
		return $this->bgColor;
	}

	/**
	 * Will return the set driver.
	 *
	 * @return string
	 */
	public function getDriver() {
		return $this->driver;
	}

	/**
	 * Will return the font color parameter.
	 *
	 * @return string
	 */
	public function getColor() {
		return $this->fontColor;
	}

	/**
	 * Will return the font size parameter.
	 *
	 * @return float
	 */
	public function getFontSize() {
		return $this->fontSize;
	}

	/**
	 * Will return the font size parameter.
	 *
	 * @return string|int
	 */
	public function getFontFile() {
		return $this->fontFile;
	}

	/**
	 * Will return the round parameter.
	 *
	 * @return bool
	 */
	public function getRounded() {
		return $this->rounded;
	}

	/**
	 * Will return the smooth parameter.
	 *
	 * @return bool
	 */
	public function getSmooth() {
		return $this->smooth;
	}

	/**
	 * Will return the round parameter.
	 *
	 * @return int
	 */
	public function getSize() {
		return $this->size;
	}

	/**
	 * Will return the keepCase parameter.
	 *
	 * @return boolean
	 */
	public function getKeepCase() {
		return $this->keepCase;
	}

	/**
	 * Will return the autofont parameter.
	 *
	 * @return bool
	 */
	public function getAutoFont() {
		return $this->autofont;
	}

	/**
	 * Set language of name, pls use `language` before `name`, just like
	 * ```php
	 * $avatar->language('en')->name('Mr Green'); // Right
	 * $avatar->name('Mr Green')->language('en'); // Wrong
	 * ```
	 *
	 * @param string $language
	 *
	 * @return $this
	 */
	public function language( $language ) {
		$this->language = $language ?: 'en';

		return $this;
	}

	/**
	 * Add new translators designed by user
	 *
	 * @param array $translatorMap
	 *     ```php
	 *     $translatorMap = [
	 *     'fr' => 'foo\bar\Fr',
	 *     'zh-TW' => 'foo\bar\ZhTW'
	 *     ];
	 *     ```
	 *
	 * @return $this
	 */
	public function addTranslators( $translatorMap ) {
		$this->translatorMap = array_merge( $this->translatorMap, $translatorMap );

		return $this;
	}

	/**
	 * @inheritdoc
	 */
	protected function translate( $nameOrInitials ) {
		return $this->getTranslator()->translate( $nameOrInitials );
	}

	/**
	 * Instance the translator by language
	 *
	 * @return Base
	 */
	protected function getTranslator() {
		if ( $this->translator instanceof Base && $this->translator->getSourceLanguage() === $this->language ) {
			return $this->translator;
		}

		$translatorClass = array_key_exists( $this->language, $this->translatorMap ) ? $this->translatorMap[ $this->language ] : 'LasseRafn\\InitialAvatarGenerator\\Translator\\En';

		return $this->translato = new $translatorClass();
	}

	/**
	 * @param ImageManager $image
	 *
	 * @return Image
	 */
	protected function makeAvatar( $image ) {
		$size     = $this->getSize();
		$bgColor  = $this->getBackgroundColor();
		$name     = $this->getInitials();
		$fontFile = $this->findFontFile();
		$color    = $this->getColor();
		$fontSize = $this->getFontSize();

		if ( $this->getRounded() && $this->getSmooth() ) {
			$size *= 5;
		}

		$avatar = $image->canvas( $size, $size, ! $this->getRounded() ? $bgColor : null );

		if ( $this->getRounded() ) {
			$avatar = $avatar->circle( $size - 2, $size / 2, $size / 2, function ( $draw ) use ( $bgColor ) {
				return $draw->background( $bgColor );
			} );
		}

		if ( $this->getRounded() && $this->getSmooth() ) {
			$size /= 5;
			$avatar->resize( $size, $size );
		}

		return $avatar->text( $name, $size / 2, $size / 2, function ( AbstractFont $font ) use ( $size, $color, $fontFile, $fontSize ) {
			$font->file( $fontFile );
			$font->size( $size * $fontSize );
			$font->color( $color );
			$font->align( 'center' );
			$font->valign( 'center' );
		} );
	}

	protected function findFontFile() {
		$fontFile = $this->getFontFile();

		if ( $this->getAutoFont() ) {
			$fontFile = $this->getFontByScript();
		}

		if ( is_int( $fontFile ) && \in_array( $fontFile, [ 1, 2, 3, 4, 5 ], false ) ) {
			return $fontFile;
		}

		$weightsToTry = [ 'Regular' ];

		if ( $this->preferBold ) {
			$weightsToTry = [ 'Bold', 'Semibold', 'Regular' ];
		}

		$originalFile = $fontFile;

		foreach ( $weightsToTry as $weight ) {
			$fontFile = preg_replace( '/(\-(Bold|Semibold|Regular))/', "-{$weight}", $originalFile );

			if ( file_exists( $fontFile ) ) {
				return $fontFile;
			}

			if ( file_exists( __DIR__ . $fontFile ) ) {
				return __DIR__ . $fontFile;
			}

			if ( file_exists( __DIR__ . '/' . $fontFile ) ) {
				return __DIR__ . '/' . $fontFile;
			}
		}

		return 1;
	}

	protected function getFontByScript() {
		// Arabic
		if ( StringScript::isArabic( $this->getInitials() ) ) {
			return __DIR__ . '/fonts/script/Noto-Arabic-Regular.ttf';
		}

		// Armenian
		if ( StringScript::isArmenian( $this->getInitials() ) ) {
			return __DIR__ . '/fonts/script/Noto-Armenian-Regular.ttf';
		}

		// Bengali
		if ( StringScript::isBengali( $this->getInitials() ) ) {
			return __DIR__ . '/fonts/script/Noto-Bengali-Regular.ttf';
		}

		// Georgian
		if ( StringScript::isGeorgian( $this->getInitials() ) ) {
			return __DIR__ . '/fonts/script/Noto-Georgian-Regular.ttf';
		}

		// Hebrew
		if ( StringScript::isHebrew( $this->getInitials() ) ) {
			return __DIR__ . '/fonts/script/Noto-Hebrew-Regular.ttf';
		}

		// Mongolian
		if ( StringScript::isMongolian( $this->getInitials() ) ) {
			return __DIR__ . '/fonts/script/Noto-Mongolian-Regular.ttf';
		}

		// Thai
		if ( StringScript::isThai( $this->getInitials() ) ) {
			return __DIR__ . '/fonts/script/Noto-Thai-Regular.ttf';
		}

		// Tibetan
		if ( StringScript::isTibetan( $this->getInitials() ) ) {
			return __DIR__ . '/fonts/script/Noto-Tibetan-Regular.ttf';
		}

		// Chinese & Japanese
		if ( StringScript::isJapanese( $this->getInitials() ) || StringScript::isChinese( $this->getInitials() ) ) {
			return __DIR__ . '/fonts/script/Noto-CJKJP-Regular.otf';
		}

		return $this->getFontFile();
	}
}
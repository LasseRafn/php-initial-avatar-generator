<?php namespace LasseRafn\InitialAvatarGenerator;

use Intervention\Image\Image;
use Intervention\Image\ImageCache;
use Intervention\Image\ImageManager;

class InitialAvatar
{
	/** @var ImageManager */
	private $image;

	private $parameter_cacheTime = 0;
	private $parameter_length    = 2;
	private $parameter_fontSize  = 0.5;
	private $parameter_initials  = 'JD';
	private $parameter_name      = 'John Doe';
	private $parameter_size      = 48;
	private $parameter_bgColor   = '#000';
	private $parameter_fontColor = '#fff';
	private $parameter_fontFile  = '/fonts/OpenSans-Regular.ttf';

	public function __construct()
	{
		$this->image = new ImageManager();
	}

	/**
	 * Set the name used for generating initials
	 *
	 * @param string $nameOrInitials
	 *
	 * @return InitialAvatar
	 */
	public function name( string $nameOrInitials ): self
	{
		$this->parameter_name     = $nameOrInitials;
		$this->parameter_initials = $this->generateInitials();

		return $this;
	}

	/**
	 * Set the length of the generated initials
	 *
	 * @param int $length
	 *
	 * @return InitialAvatar
	 */
	public function length( int $length = 2 ): self
	{
		$this->parameter_length   = (int) $length;
		$this->parameter_initials = $this->generateInitials();

		return $this;
	}

	/**
	 * Set time avatar/image size in pixels
	 *
	 * @param int $size
	 *
	 * @return InitialAvatar
	 */
	public function size( int $size ): self
	{
		$this->parameter_size = (int) $size;

		return $this;
	}

	/**
	 * Set the background color
	 *
	 * @param string $background
	 *
	 * @return InitialAvatar
	 */
	public function background( string $background ): self
	{
		$this->parameter_bgColor = (string) $background;

		return $this;
	}

	/**
	 * Set the font color
	 *
	 * @param string $color
	 *
	 * @return InitialAvatar
	 */
	public function color( string $color ): self
	{
		$this->parameter_fontColor = (string) $color;

		return $this;
	}

	/**
	 * Set the font file by path
	 *
	 * @param string $font
	 *
	 * @return InitialAvatar
	 */
	public function font( string $font ): self
	{
		$this->parameter_fontFile = (string) $font;

		return $this;
	}

	/**
	 * Set cache time (in minutes)
	 * 0 = no cache
	 *
	 * @param int $minutes
	 *
	 * @return InitialAvatar
	 */
	public function cache( int $minutes = 60 ): self
	{
		$this->parameter_cacheTime = (int) $minutes;

		return $this;
	}

	/**
	 * Set the font size in percentage
	 * (0.1 = 10%)
	 *
	 * @param float $size
	 *
	 * @return InitialAvatar
	 */
	public function fontSize( float $size = 0.5 ): self
	{
		$this->parameter_fontSize = number_format( $size, 2 );

		return $this;
	}

	/**
	 * Generate the image
	 *
	 * @param null|string $name
	 *
	 * @return Image
	 */
	public function generate( $name = null ): Image
	{
		if ( $name !== null )
		{
			$this->parameter_name     = $name;
			$this->parameter_initials = $this->generateInitials();
		}

		if ( $this->parameter_cacheTime === 0 )
		{
			$img = $this->makeAvatar( $this->image );
		}
		else
		{
			$img = $this->image->cache( function ( ImageCache $image )
			{
				return $this->makeAvatar( $image );
			}, $this->parameter_cacheTime, true );
		}

		return $img;
	}

	/**
	 * Will return the generated initials
	 *
	 * @return string
	 */
	public function getInitials(): string
	{
		return $this->parameter_initials;
	}

	/**
	 * Will return the background color parameter
	 *
	 * @return string
	 */
	public function getParameterBackgroundColor(): string
	{
		return $this->parameter_bgColor;
	}

	/**
	 * Will return the font color parameter
	 *
	 * @return string
	 */
	public function getParameterColor(): string
	{
		return $this->parameter_fontColor;
	}

	/**
	 * Will return the font size parameter
	 *
	 * @return float
	 */
	public function getParameterFontSize(): float
	{
		return $this->parameter_fontSize;
	}

	/**
	 * Will return the font size parameter
	 *
	 * @return string
	 */
	public function getParameterFontFile(): string
	{
		return $this->parameter_fontFile;
	}

	/**
	 * Generate a two-letter initial from a name,
	 * and if no name, assume its already initials.
	 * For safety, we limit it to two characters,
	 * in case its a single, but long, name.
	 *
	 * @return string
	 */
	private function generateInitials(): string
	{
		$nameOrInitials = mb_strtoupper( trim( $this->parameter_name ) );
		$names          = explode( ' ', $nameOrInitials );
		$initials       = $nameOrInitials;
		$assignedNames  = 0;

		if ( count( $names ) > 1 )
		{
			$initials = '';
			$start    = 0;

			for ( $i = 0; $i < $this->parameter_length; $i ++ )
			{
				$index = $i;

				if ( ( $index === ( $this->parameter_length - 1 ) && $index > 0 ) || ( $index > ( count( $names ) - 1 ) ) )
				{
					$index = count( $names ) - 1;
				}

				if ( $assignedNames >= count( $names ) )
				{
					$start ++;
				}

				$initials .= mb_substr( $names[ $index ], $start, 1 );
				$assignedNames ++;
			}
		}

		$initials = mb_substr( $initials, 0, $this->parameter_length );

		return $initials;
	}

	/**
	 * @param ImageManager|ImageCache $image
	 *
	 * @return Image|ImageCache
	 */
	private function makeAvatar( $image )
	{
		$size     = $this->parameter_size;
		$bgColor  = $this->parameter_bgColor;
		$name     = $this->parameter_initials;
		$fontFile = $this->parameter_fontFile;
		$color    = $this->parameter_fontColor;
		$fontSize = $this->parameter_fontSize;

		return $image->canvas( $size, $size, $bgColor )->text( $name, $size / 2, $size / 2, function ( $font ) use ( $size, $color, $fontFile, $fontSize )
		{
			$font->file( __DIR__ . $fontFile );
			$font->size( $size * $fontSize );
			$font->color( $color );
			$font->align( 'center' );
			$font->valign( 'center' );
		} );
	}
}
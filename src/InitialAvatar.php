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

	public function name( string $nameOrInitials ): self
	{
		$this->parameter_name     = $nameOrInitials;
		$this->parameter_initials = $this->generateInitials();

		return $this;
	}

	public function length( int $length = 2 ): self
	{
		$this->parameter_length   = (int) $length;
		$this->parameter_initials = $this->generateInitials();

		return $this;
	}

	public function size( int $size ): self
	{
		$this->parameter_size = (int) $size;

		return $this;
	}

	public function background( string $background ): self
	{
		$this->parameter_bgColor = (string) $background;

		return $this;
	}

	public function color( string $color ): self
	{
		$this->parameter_fontColor = (string) $color;

		return $this;
	}

	public function font( string $font ): self
	{
		$this->parameter_fontFile = (string) $font;

		return $this;
	}

	public function cache( int $minutes = 60 ): self
	{
		$this->parameter_cacheTime = (int) $minutes;

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
			$this->parameter_initials = $this->generateInitials( $this->parameter_name );
		}

		$fontFile = $this->parameter_fontFile;
		$size     = $this->parameter_size;
		$color    = $this->parameter_fontColor;
		$bgColor  = $this->parameter_bgColor;
		$name     = $this->parameter_initials;

		$img = $this->image->cache( function ( ImageCache $image ) use ( $size, $bgColor, $color, $fontFile, $name )
		{
			$image->canvas( $size, $size, $bgColor )->text( $name, $size / 2, $size / 2, function ( $font ) use ( $size, $color, $fontFile )
			{
				$font->file( __DIR__ . $fontFile );
				$font->size( $size / 2 );
				$font->color( $color );
				$font->align( 'center' );
				$font->valign( 'center' );
			} );
		}, $this->parameter_cacheTime, true );

		return $img;
	}

	/**
	 * Will return the generated initials
	 *
	 * @return string
	 */
	public function getInitials()
	{
		return $this->parameter_initials;
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
}
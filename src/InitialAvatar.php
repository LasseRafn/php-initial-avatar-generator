<?php namespace LasseRafn\InitialAvatarGenerator;

use Intervention\Image\Image;
use Intervention\Image\ImageManager;

class InitialAvatar
{
	/** @var ImageManager */
	private $image;

	private $parameter_name      = 'John Doe';
	private $parameter_size      = 48;
	private $parameter_bgColor   = '#000';
	private $parameter_fontColor = '#fff';
	private $parameter_fontFile  = '/fonts/OpenSans-Regular.ttf';

	public function __construct()
	{
		$this->image = new ImageManager();
	}

	public function name( string $nameOrInitials ): this
	{
		$this->parameter_name = $this->generateInitials( $nameOrInitials );

		return $this;
	}

	public function size( int $size ): this
	{
		$this->parameter_size = (int) $size;

		return $this;
	}

	public function background( string $background ): this
	{
		$this->parameter_bgColor = (string) $background;

		return $this;
	}

	public function color( string $color ): this
	{
		$this->parameter_fontColor = (string) $color;

		return $this;
	}

	public function font( string $font ): this
	{
		$this->parameter_fontFile = (string) $font;

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
			$this->parameter_name = $this->generateInitials( $name );
		}

		$fontFile = $this->parameter_fontFile;
		$size     = $this->parameter_size;
		$color    = $this->parameter_fontColor;

		$img = $this->image->canvas( $size, $size, $this->parameter_bgColor );

		$img->text( $this->parameter_name, $size / 2, $size / 2, function ( $font ) use ( $size, $color, $fontFile )
		{
			$font->file( __DIR__ . $fontFile );
			$font->size( $size / 2 );
			$font->color( $color );
			$font->align( 'center' );
			$font->valign( 'center' );
		} );

		return $img;
	}

	/**
	 * Generate a two-letter initial from a name,
	 * and if no name, assume its already initials.
	 * For safety, we limit it to two characters,
	 * in case its a single, but long, name.
	 *
	 * @param string $nameOrInitials
	 *
	 * @return string
	 */
	private function generateInitials( string $nameOrInitials = 'John Doe' ): string
	{
		$nameOrInitials = strtoupper( trim( $nameOrInitials ) );

		$names = explode( ' ', $nameOrInitials );

		if ( count( $names ) > 1 )
		{
			$firstNameLetter = substr( $names[0], 0, 1 );
			$lastNameLetter  = substr( $names[ count( $names ) - 1 ], 0, 1 );

			$nameOrInitials = "{$firstNameLetter}{$lastNameLetter}";
		}

		$nameOrInitials = substr( $nameOrInitials, 0, 2 );

		return $nameOrInitials;
	}
}
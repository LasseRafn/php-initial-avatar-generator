<?php namespace LasseRafn\InitialAvatarGenerator;

use Intervention\Image\Image;

class InitialAvatar
{
	/** @var Image */
	private $image;

	public function __construct()
	{
		$this->image = new Image();
	}

	/**
	 * @param        $nameOrInitials
	 * @param string $bgColor
	 * @param string $fontColor
	 * @param int    $size
	 * @param string $font
	 *
	 * @return Image
	 */
	public function generate( $nameOrInitials, $bgColor = '#000', $fontColor = '#fff', $size = 48, $font = 'OpenSans-Regular' )
	{
		$img = $this->image->canvas( $size, $size, $bgColor );

		$img->text( $this->generateInitials( $nameOrInitials ), 0, 0, function ( $font ) use ( $fontColor, $size, $font )
		{
			$font->file( "fonts/{$font}.ttf" );
			$font->size( $size * 0.75 );
			$font->color( $fontColor );
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
	private function generateInitials( $nameOrInitials = 'John Doe' )
	{
		$nameOrInitials = strtoupper( trim( $nameOrInitials ) );

		$names = explode( $nameOrInitials, ' ' );
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
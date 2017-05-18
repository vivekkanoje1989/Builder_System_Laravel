jQuery( function ( $ )
{
	// Tabs
	$( '.fitwp-tabs' ).each( function ()
	{
		var $this = $( this ),
			$ul = $this.children( 'ul' ),
			$lis = $ul.children(),
			$content = $this.children( 'div' ),
			$divs = $content.children();

		$lis.filter( ':first' ).addClass( 'fitwp-active' );
		$divs.filter( ':first' ).addClass( 'fitwp-active' );

		$ul.on( 'click', 'li', function ()
		{
			$lis.removeClass( 'fitwp-active' );
			$( this ).addClass( 'fitwp-active' );

			$divs.removeClass( 'fitwp-active' )
				.filter( ':eq(' + $lis.index( this ) + ')' ).addClass( 'fitwp-active' );

			return false;
		} );

	} );
} );
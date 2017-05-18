// Paralax plugin
(function( $ )
{
	var $window = $( window );

	$.fn.parallax = function( xpos, speedFactor )
	{
		xpos = xpos || '50%';
		speedFactor = speedFactor || 0.6;

		return this.each( function()
		{
			var $this = $( this ),
				height = $this.height(),
				top = $this.offset().top;

			// Called whenever the window is scrolled or resized
			function update()
			{
				var pos = $window.scrollTop();

				// Check if totally above or totally below viewport
				if ( top + height < pos || top > pos + $window.height() )
					return;

				$this.css( 'backgroundPosition', xpos + ' ' + Math.round( (top - pos) * speedFactor ) + 'px' );
			}

			$window.on( 'scroll', update );
			update();
		} );
	};
})( jQuery );

// var building = window.building || {};
jQuery( document ).ready( function( $ )
{
	'use strict';

	/**
	 * Variables
	 */
	var $window = $( window ),
		$body = $( 'body' ),
		$header = $( '#masthead' ),
		fluidRows = document.getElementsByClassName( 'row-fluid' );

	/**
	 * Bootstrap Twitter Dropdown: Make the parent follow the link
	 */
	$( '.nav' ).on( 'click', 'a.dropdown-toggle', function () {
		if ( $window.width() > 768 )
			window.location = $( this ).attr( 'href' );
	});

	/**
	 * Row full width
	 */
	$window.resize( function()
	{
		var wWidth = $( '#page' ).outerWidth(),
			$el = null;

		for ( var i = 0; i < fluidRows.length; i++ )
		{
			$el = $( fluidRows[i] );

			if ( $el.hasClass( 'row-fluid-content' ) )
			{
				var margin = 0;

				if ( $el.hasClass( 'resized' ) )
					margin = ( wWidth - $el.parent().width() ) / 2;
				else
					margin = ( wWidth - $el.width() ) / 2;

				$el.width( wWidth ).addClass( 'resized' );
				$el.css( 'marginLeft', -margin );
			}
			else
			{
				var padding = ( wWidth - $el.parent().width() ) / 2;

				$el.css( {
					paddingLeft: padding,
					paddingRight: padding,
					marginLeft: -padding,
					marginRight: -padding
				} );
			}
		}

		/**
		 * Footer sidebar bg
		 */
		if ( $( '.footer-sidebars' ).length )
		{
			$( '.footer-sidebars-bg' ).width( function()
			{
				var offset = ( wWidth - $( '.footer-sidebars > .container' ).outerWidth() ) / 2;
				return offset + $( '.footer-sidebars .footer-widgets:first-child' ).outerWidth();
			} );
		}
	} ).trigger( 'resize' );

	/**
	 * Parallax
	 */
	if ( $window.width() >= 768 )
		$( '.row-background.row-parallax' ).parallax();

	/**
	 * Fitvids *
	 */
	$( '#main' ).fitVids();

	/**
	 * Toggle search form
	 */
	var $searchFormHeader = $( '#search-form-header' );
	$( '.search-wrapper' ).on( 'click', '.search-icon', function( e )
	{
		e.preventDefault();
		$searchFormHeader.toggleClass( 'active' );
	} );

	$searchFormHeader.find( '.icon-close' ).on( 'click', function( e )
	{
		e.preventDefault();
		$searchFormHeader.removeClass( 'active' );
	} );

	/**
	 * Sticky header
	 */
	if ( $body.hasClass( 'header-sticky' ) )
	{
		var $topbar = $( '#topbar' ),
			offset = $topbar.length ? $topbar.height() : 0;

		$window.scroll( function()
		{
			if ( $window.scrollTop() >= offset )
				$header.addClass( 'sticky' );
			else
				$header.removeClass( 'sticky' );
		} );
	}

	/**
	 * Show/hide meta data
	 */
	$( '.media-info-toggle' ).on( 'click', function()
	{
		$( this ).prev().slideToggle( 'slow' );
		$( this ).toggleClass( 'active' );
	} );

	/**
	 * Team members carousel
	 */
	$( '.fitsc-team .team-members' ).owlCarousel( {
		navigation: true,
		navigationText: ['<i class="fa fa-long-arrow-left"></i>', '<i class="fa fa-long-arrow-right"></i>'],
		pagination: false
	} );

	/**
	 * Testimonials
	 */
	$( '.fitsc-testimonials' ).owlCarousel( {
		navigation: false,
		pagination: true,
		singleItem: true,
		autoPlay: 5000
	} );

	/**
	 * Shortcode portfolio
	 */
	$( '.fitsc-portfolio' ).each( function()
	{
		var $this = $( this ),
			$projects = $this.children( '.projects' );

		$projects.imagesLoaded( function()
		{
			$projects.shuffle( {
				speed: 500,
				itemSelector: '.project'
			} );
		} );

		$this.on( 'click', '.portfolio-filter a', function( e )
		{
			e.preventDefault();
			var $el = $( this ),
				group = $el.data( 'group' );

			if ( $el.hasClass( 'active' ) )
			{
				return;
			}

			$( this ).addClass( 'active' ).siblings().removeClass( 'active' );

			$projects.shuffle( 'shuffle', group );
		} );
	} );

	/**
	 * Shortcode counter
	 */
	$( '.fitsc-counter .counter' ).counterUp( {
		delay: 20,
		time: 2000
	} );

	/**
	 * Shortcode images carousel
	 */
	$( '.images-carousel' ).owlCarousel( {
		navigation: true,
		navigationText: ['<i class="fa fa-long-arrow-left"></i>', '<i class="fa fa-long-arrow-right"></i>'],
		pagination: false,
		autoPlay: 5000,
		afterInit: function()
		{
			window.console.log( this );
		},
		afterAction: function()
		{
			var currentItemClass = 'current-item';
			this.$owlItems.removeClass( 'current-item last-visible' );

			for ( var i = 0; i < this.owl.visibleItems.length; i++ )
			{
				if ( this.owl.visibleItems.length === (i + 1) )
				{
					currentItemClass += ' last-visible';
				}

				this.$owlItems.eq(this.owl.visibleItems[i]).addClass( currentItemClass );
			}
		}
	} );

	/**
	 * Portfolio detail gallery slider
	 */
	$( '.project-images' ).owlCarousel( {
		navigation: false,
		pagination: true,
		autoPlay: 5000,
		singleItem: true,
		autoHeight: true
	} );

	/**
	 * Pie chart
	 */
	$( '.piechart' ).circliful();

	/**
	 * Gallery lightbox
	 */
	$( '.gallery .gallery-item a' ).colorbox( {
		rel: true,
		slideshow: false,
		current: false,
		previous: '<i class="fa fa-long-arrow-left"></i>',
		next: '<i class="fa fa-long-arrow-right"></i>',
		close: '<i class="fa fa-remove"></i>'
	} );
} );

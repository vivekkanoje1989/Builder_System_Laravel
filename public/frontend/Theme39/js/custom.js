
jQuery( function ( $ )
{
	var $body = $( 'body' );

	// Tabs
	$( '.fitsc-tabs' ).each( function ()
	{
		var $this = $( this ),
			$ul = $this.children( 'ul' ),
			$lis = $ul.children(),
			$content = $this.children( 'div' ),
			$divs = $content.children();

		$lis.filter( ':first' ).addClass( 'fitsc-active' );
		$divs.filter( ':first' ).addClass( 'fitsc-active' );

		$ul.on( 'click', 'li', function ()
		{
			$lis.removeClass( 'fitsc-active' );
			$( this ).addClass( 'fitsc-active' );

			$divs.removeClass( 'fitsc-active' )
				.filter( ':eq(' + $lis.index( this ) + ')' ).addClass( 'fitsc-active' );

			return false;
		} );

		// Tabs vertical
		if ( ( $this ).hasClass( 'fitsc-vertical' ) )
		{
			$content.css( 'marginLeft', $ul.width() );
		}
	} );

	// Accordions
	$body.on( 'click', '.fitsc-accordion .fitsc-title', function ()
	{
		var $this = $( this ),
			$parent = $this.parent(),
			$pane = $this.siblings(),
			$others = $parent.siblings();

		if ( $parent.hasClass( 'fitsc-active' ) )
		{
			$pane.slideUp();
			$parent.removeClass( 'fitsc-active' );
		}
		else
		{
			$others.removeClass( 'fitsc-active' ).find( '.fitsc-content' ).slideUp();
			$parent.addClass( 'fitsc-active' );
			$pane.slideDown();
		}
	} );

	// Toggles
	$body.on( 'click', '.fitsc-toggle .fitsc-title', function ()
	{
		var $this = $( this ),
			$parent = $this.parent(),
			$pane = $this.siblings();

		if ( $parent.hasClass( 'fitsc-active' ) )
		{
			$pane.slideUp();
			$parent.removeClass( 'fitsc-active' );
		}
		else
		{
			$parent.addClass( 'fitsc-active' );
			$pane.slideDown();
		}
	} );

	// Progress bars
	$( '.fitsc-percent' ).each( function ()
	{
		var $this = $( this ),
			percentage = $this.data( 'percentage' );

		$this.css( 'width', '0' );
		$this.animate( {
			width: percentage + '%'
		}, 3000 );
	} );

	// Box close
	$body.on( 'click', '.fitsc-box .fitsc-close', function ()
	{
		$( this ).parent().slideUp( 500 );
	} );
	
	
		$(".scroll-top").click(function(e){
		$("html, body").animate({ scrollTop: "0" }, 900 );
		  return false; 	
		});
		 
	
} );



/******************************************
	-	PREPARE PLACEHOLDER FOR SLIDER	-
******************************************/
	var tpj=jQuery;			
	var revapi4;
	tpj(document).ready(function() {
		if(tpj("#rev_slider_4_1").revolution == undefined){
			revslider_showDoubleJqueryError("#rev_slider_4_1");
		}else{
			revapi4 = tpj("#rev_slider_4_1").show().revolution({
				sliderType:"standard",
				jsFileLocation:"../../revolution/js/",
				sliderLayout:"fullwidth",
				dottedOverlay:"none",
				delay:3000,
				navigation: {
					keyboardNavigation:"off",
					keyboard_direction: "horizontal",
					mouseScrollNavigation:"off",
					onHoverStop:"off",
					touch:{
						touchenabled:"on",
						swipe_threshold: 75,
						swipe_min_touches: 1,
						swipe_direction: "horizontal",
						drag_block_vertical: false
					}
					,
					arrows: {
						style:"zeus",
						enable:true,
						hide_onmobile:true,
						hide_under:600,
						hide_onleave:true,
						hide_delay:200,
						hide_delay_mobile:1200,
						tmp:'<div class="tp-title-wrap">  	<div class="tp-arr-imgholder"></div> </div>',
						left: {
							h_align:"left",
							v_align:"center",
							h_offset:30,
							v_offset:0
						},
						right: {
							h_align:"right",
							v_align:"center",
							h_offset:30,
							v_offset:0
						}
					}
					,
					bullets: {
						enable:false,
						hide_onmobile:true,
						hide_under:600,
						style:"metis",
						hide_onleave:true,
						hide_delay:200,
						hide_delay_mobile:1200,
						direction:"horizontal",
						h_align:"center",
						v_align:"bottom",
						h_offset:0,
						v_offset:30,
						space:5,
						tmp:'<span class="tp-bullet-img-wrap">  <span class="tp-bullet-image"></span></span><span class="tp-bullet-title">{{title}}</span>'
					}
				},
				viewPort: {
					enable:true,
					outof:"pause",
					visible_area:"80%"
				},
				responsiveLevels:[1240,1024,778,480],
				gridwidth:[1240,1024,778,480],
				gridheight:[600,600,500,400],
				lazyType:"none",
				parallax: {
					type:"mouse",
					origo:"slidercenter",
					speed:200,
					levels:[2,3,4,5,6,7,12,16,10,50],
				},
				shadow:0,
				spinner:"off",
				stopLoop:"off",
				stopAfterLoops:-1,
				stopAtSlide:-1,
				shuffle:"off",
				autoHeight:"off",
				hideThumbsOnMobile:"off",
				hideSliderAtLimit:0,
				hideCaptionAtLimit:0,
				hideAllCaptionAtLilmit:0,
				debugMode:false,
				fallbacks: {
					simplifyAll:"off",
					nextSlideOnWindowFocus:"off",
					disableFocusListener:false,
				}
			});
		}
	});	/*ready*/
var htmlDiv = document.getElementById("rs-plugin-settings-inline-css");
	var htmlDivCss = ".tp-caption.Fashion-BigDisplay,.Fashion-BigDisplay{color:rgba(0,0,0,1.00);font-size:60px;line-height:60px;font-weight:900;font-style:normal;font-family:Raleway;padding:0 0 0 0px;text-decoration:none;background-color:transparent;border-color:transparent;border-style:none;border-width:0px;border-radius:0 0 0 0px;letter-spacing:2px}.tp-caption.Fashion-TextBlock,.Fashion-TextBlock{color:rgba(0,0,0,1.00);font-size:20px;line-height:40px;font-weight:400;font-style:normal;font-family:Raleway;padding:0 0 0 0px;text-decoration:none;background-color:transparent;border-color:transparent;border-style:none;border-width:0px;border-radius:0 0 0 0px;letter-spacing:2px}";
	if (htmlDiv) {
		htmlDiv.innerHTML = htmlDiv.innerHTML + htmlDivCss;
	} else {
		var htmlDiv = document.createElement("div");
		htmlDiv.innerHTML = "<style>" + htmlDivCss + "</style>";
		document.getElementsByTagName("head")[0].appendChild(htmlDiv.childNodes[0]);
	}

	var htmlDivCss = unescape(".rev_slider%20.slotholder%3Aafter%20%7B%0A%20%20%20%20width%3A%20100%25%3B%0A%20%20%20%20height%3A%20100%25%3B%0A%20%20%20%20content%3A%20%22%22%3B%0A%20%20%20%20position%3A%20absolute%3B%0A%20%20%20%20left%3A%200%3B%0A%20%20%20%20top%3A%200%3B%0A%20%20%20%20pointer-events%3A%20none%3B%0A%20%0A%20%20%20%20%2F%2A%20black%20overlay%20with%2050%25%20transparency%20%2A%2F%0A%20%20%20%20background%3A%20rgba%2838%2C%2030%2C%2076%2C%200.7%29%0A%7D");
	var htmlDiv = document.getElementById('rs-plugin-settings-inline-css');
	if (htmlDiv) {
		htmlDiv.innerHTML = htmlDiv.innerHTML + htmlDivCss;
	} else {
		var htmlDiv = document.createElement('div');
		htmlDiv.innerHTML = '<style>' + htmlDivCss + '</style>';
		document.getElementsByTagName('head')[0].appendChild(htmlDiv.childNodes[0]);
	}
	
	var htmlDivCss = unescape(".custom.tparrows%20%7B%0A%09cursor%3Apointer%3B%0A%09background%3A%23000%3B%0A%09background%3Argba%280%2C0%2C0%2C0.5%29%3B%0A%09width%3A40px%3B%0A%09height%3A40px%3B%0A%09position%3Aabsolute%3B%0A%09display%3Ablock%3B%0A%09z-index%3A100%3B%0A%7D%0A.custom.tparrows%3Ahover%20%7B%0A%09background%3A%23000%3B%0A%7D%0A.custom.tparrows%3Abefore%20%7B%0A%09font-family%3A%20%22revicons%22%3B%0A%09font-size%3A15px%3B%0A%09color%3A%23fff%3B%0A%09display%3Ablock%3B%0A%09line-height%3A%2040px%3B%0A%09text-align%3A%20center%3B%0A%7D%0A.custom.tparrows.tp-leftarrow%3Abefore%20%7B%0A%09content%3A%20%22%5Ce824%22%3B%0A%7D%0A.custom.tparrows.tp-rightarrow%3Abefore%20%7B%0A%09content%3A%20%22%5Ce825%22%3B%0A%7D%0A%0A%0A");
	var htmlDiv = document.getElementById('rs-plugin-settings-inline-css');
	if (htmlDiv) {
		htmlDiv.innerHTML = htmlDiv.innerHTML + htmlDivCss;
	} else {
		var htmlDiv = document.createElement('div');
		htmlDiv.innerHTML = '<style>' + htmlDivCss + '</style>';
		document.getElementsByTagName('head')[0].appendChild(htmlDiv.childNodes[0]);
	}
	
	
	
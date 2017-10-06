(function($) {

	'use strict';

	$(document).ready(function() {

		var $search = $('.form-search');

		/*============================================
		=            Show/hide navigation            =
		============================================*/
		$('.btn-nav').on('click', function() {
			$('body').toggleClass('nav-main-active');
			$search.removeClass('active');
			if ($('.nav-main-item-sub .active').length < 1 && !$('.nav-main > ul').hasClass('active')) {
				$('.nav-main > ul').addClass('active');
			}
		});

		/*=======================================
		=            Init slideshows            =
		=======================================*/
		$('.owl-carousel').each(function () {
			var	owl = $(this),
				itemOptions = owl.data('slideshow-options'),
				defaultOptions = {
					singleItem: true,
					navigation: true,
					addClassActive: true,
					theme: 'owl-squarefolio'
				};
			owl.owlCarousel($.extend(defaultOptions, itemOptions));
		});

		/*======================================================
		=            Init thumbnails grid & filtering            =
		======================================================*/
		

		/*=============================================
		=            Show/hide search form            =
		=============================================*/
		$('.nav-main').on('click', '.btn-search', function(e) {
			e.preventDefault();
			$search.addClass('active');
			$('body').removeClass('nav-main-active');
		});
		$search.on('click', '.btn-close', function(e) {
			e.preventDefault();
			$search.removeClass('active');
		});

		/*==========================================
		=            Init progress bars            =
		==========================================*/
		var progressElems = document.querySelectorAll('.progress');
		Array.prototype.forEach.call(progressElems, function (el, i) {
			var progressVal = el.getAttribute('data-progress'),
				progress;
			if ($(el).hasClass('progress-line')) {
				progress = new ProgressBar.Line(progressElems[i], {
					easing: 'easeInOut',
					text: {
						value: '0'
					},
					step: function(state, bar) {
						bar.setText((bar.value() * 100).toFixed(0) + '%');
					}
				});
			} else {
				progress = new ProgressBar.Circle(progressElems[i], {
					easing: 'easeInOut',
					strokeWidth: 10,
					text: {
						value: '0'
					},
					step: function(state, bar) {
						bar.setText((bar.value() * 100).toFixed(0) + '%');
					}
				});
			}
			$(el).bind('inview', function(event, isInView) {
				if (isInView) {
					if (!$(el).hasClass('active')) {
						progress.animate(progressVal / 100);
						$(el).addClass('active');
					}
				}
			});
		});

		/*=============================
		=            Stats            =
		=============================*/
		$('.stat').each(function() {
			var $el = $(this),
				$valEl = $el.find('span'),
				statVal = $el.data('value');
			$el.bind('inview', function(event, isInView) {
				if (isInView) {
					if ($valEl.text() <= 0) {
						jQuery({someValue: 0}).animate({someValue: statVal}, {
							duration: 2000,
							easing: 'swing',
							step: function() {
								$valEl.text(Math.ceil(this.someValue));
							}
						});
					}
				}
			});
		});

		/*=================================
		=            Init tabs            =
		=================================*/
		$('.tabs').on('click', '.tabs-nav li', function(e){
			e.preventDefault();
			var tab = $('a', this).attr('href');
			$(this).addClass('active').siblings().removeClass('active').parents('.tabs').find(tab).addClass('active').siblings('.tabs-item').removeClass('active');
		});

		/*======================================
		=            Init accordion            =
		======================================*/
		$('.accordion-item').each(function() {
			var $self = $(this);
			if ($self.hasClass('active')) {
				$self.find('.accordion-item-inner').slideToggle();
			}
		});

		$('.accordion').on('click', '.accordion-item-heading', function(){
			var $item = $(this).parent();
			$item.toggleClass('active').find('.accordion-item-inner').slideToggle();
			$item.siblings().removeClass('active').find('.accordion-item-inner').slideUp();
		});

		/*====================================
		=            Init toggles            =
		====================================*/
		$('.toggle').on('click', '.toggle-heading', function(){
			var $item = $(this).parent();
			$item.toggleClass('active').find('.toggle-inner').slideToggle();
		});

		/*===========================================
		=            Init page scrolling            =
		===========================================*/
		$('.btn-scroll').on('click', function(e) {
			e.preventDefault();
			var target = $(this).attr('href'),
				targetTopPosition = $(target).offset();
			$('html,body').animate({scrollTop: (targetTopPosition.top)}, 400);
		});

		/*=======================================================
		=            Reveal elements while scrolling            =
		=======================================================*/
		var revealElems = document.querySelectorAll('.reveal');
		Array.prototype.forEach.call(revealElems, function (el) {
			$(el).bind('inview', function(event, isInView) {
				if (isInView) {
					$(this).addClass('revealed');
				}
			});
		});

		/*===================================
		=            Init tweets            =
		===================================*/
		var tweetsId = 'tweets',
		tweetsEl = document.getElementById(tweetsId);
		if (tweetsEl) {
			var tweetsConfig = {
				'id': tweetsEl.getAttribute('data-id'),
				'domId': tweetsId,
				'maxTweets': 3,
				'showInteraction': false,
				'showTime': false
			};
			twitterFetcher.fetch(tweetsConfig);
		}

//		/*=================================================
//		=            Init form inputs styling             =
//		=================================================*/
//		$('select, input[type="checkbox"], input[type="radio"], input[type="file"], input[type="number"]').styler({
//			filePlaceholder: 'No file selected',
//			fileBrowse: 'Browse…'
//		});

		/*==================================
		=            Validation            =
		==================================*/
//		$('form').each( function() {
//			$(this).validate();
//		});

		/*===================================
		=            Form submit            =
		===================================*/
		$('.form-contact').submit(function(e){
			e.preventDefault();
			var $form = $(this),
				$submit = $form.find('[type="submit"]');
			if( $form.valid() ){
				var dataString = $form.serialize();
				$submit.after('<div class="loader"></div>');
				$.ajax({
					type: $form.attr('method'),
					url: $form.attr('action'),
					data: dataString,
					success: function() {
						$submit.parent().after('<div class="message message-success">Your message was sent successfully!</div>');
					},
					error: function() {
						$submit.parent().after('<div class="message message-error">Your message wasn\'t sent, please try again.</div>');
					},
					complete: function() {
						$form.find('.loader').remove();
						$form.find('.message').fadeIn();
						setTimeout(function() {
							$form.find('.message').fadeOut(function() {
								$(this).remove();
							});
						}, 5000);
					}
				});
			}
		});

		/*==============================
		=            Popups            =
		==============================*/
//		$('.btn-popup').magnificPopup({
//			mainClass: 'squarefolio',
//			removalDelay: 300
//		});
//
//		$('.btn-lightbox').magnificPopup({
//			type: 'image',
//			mainClass: 'squarefolio',
//			removalDelay: 300
//		});

		$('.gallery').each(function() {
			$(this).magnificPopup({
				delegate: 'a',
				type: 'image',
				mainClass: 'squarefolio',
				gallery: {
					enabled: true
				},
				removalDelay: 300
			});
		});

		/*=====================================
		=            Media queries            =
		=====================================*/
		function handleWidthChange(mqlVal) {
			if (mqlVal.matches) {

				/*================================================
				=            Show/hide sub navigation            =
				================================================*/
				$('.nav-main-item-sub .nav-main-link').on('click', function(e) {
					e.preventDefault();
					$('.nav-main ul.active').removeClass('active');
					$(this).next('ul').addClass('active');
				});

				$('.nav-main-item-back a').on('click', function(e) {
					e.preventDefault();
					$(this).parents('ul.active').removeClass('active').parents('ul').addClass('active');
				});

				/*=================================
				=            Filtering            =
				=================================*/
				$('.filter').each(function() {
					$(this).on('click', 'li', function() {
						var self = $(this);
						self.addClass('active').siblings().removeClass('active');
					});
				});

				/*=================================================
				=            Remove sticky positioning            =
				=================================================*/
				$('.sticky').each(function(){
					$(this).trigger('sticky_kit:detach');
				});

			} else {

				$('.nav-main-item-sub .nav-main-link').unbind('click');

				/*==============================================
				=            Add sticky positioning            =
				==============================================*/
				$('.sticky').each(function(){
					var parent = $(this).data('sticky-parent'),
					offset = $(this).data('sticky-offset');
					$(this).stick_in_parent({
						parent: parent,
						offset_top: offset
					});
				});

				/*===============================================
				=            Filter marker animation            =
				===============================================*/
				$('.filter').each(function() {
					$(this).append('<div class="filter-marker"></div>');

					var $filterMarker = $('.filter-marker', this);

					$filterMarker.data('originalLeft', 0).data('originalTop', 0).data('originalWidth', '100%').data('originalHeight', $filterMarker.parent().height());

					$('li', this).hover(function() {
						var $el = $(this);
						$filterMarker.css({
							left: $el.position().left,
							top: $el.position().top,
							width: $el.width(),
							height: $el.height()
						});
					}, function() {
						var $el = $(this);
						$filterMarker.css({
							left: $filterMarker.data('originalLeft'),
							top: $filterMarker.data('originalTop'),
							width: $filterMarker.data('originalWidth')
						});
						if ($filterMarker.data('originalHeight') > $el.height()){
							$filterMarker.css('height', $filterMarker.data('originalHeight'));
						} else {
							$filterMarker.css('height', $el.height());
						}
					});

					$(this).on('click', 'li', function() {
						var self = $(this),
						group = self.data('group'),
						position = self.position();
						self.addClass('active').siblings().removeClass('active');
						if (group === 'all'){
							$filterMarker.data('originalLeft', '0').data('originalTop', '0').data('originalWidth', '100%').data('originalHeight', $filterMarker.parent().height());
						} else {
							$filterMarker.data('originalLeft', position.left).data('originalTop', position.top).data('originalWidth', self.width()).data('originalHeight', self.height());
						}
					});
				});

			}
		}

		if (window.matchMedia) {
			var mql = window.matchMedia('(max-width: 1279px)');
			mql.addListener(handleWidthChange);
			handleWidthChange(mql);
		}

	});

})(jQuery);

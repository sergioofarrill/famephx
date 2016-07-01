/*-----------------------------------------------------------------------------------*/
/*	Custom Footer JS
/*-----------------------------------------------------------------------------------*/

jQuery.fn.topLink = function(settings) {
		settings = jQuery.extend({
			min: 1,
			fadeSpeed: 200,
			ieOffset: 50
		}, settings);
		return this.each(function() {
			//listen for scroll
			var el = jQuery(this);
			el.css('display','none'); //in case the user forgot
			jQuery(window).scroll(function() {
				if(!jQuery.support.hrefNormalized) {
					el.css({
						'position': 'absolute',
						'top': jQuery(window).scrollTop() + jQuery(window).height() - settings.ieOffset
					});
				}
				if(jQuery(window).scrollTop() >= settings.min)
				{
					el.fadeIn(settings.fadeSpeed);
				}
				else
				{
					el.fadeOut(settings.fadeSpeed);
				}
			});
		});
};
 
(function($) {
			
	/*-----------------------------------------------------------------------------------*/
	/*	Superfish Drop-Down Menu
	/*-----------------------------------------------------------------------------------*/
	
	if ( jQuery().superfish ) {
		
		$('#menu ul').superfish({
			delay: 700,
			animation: { opacity: 'show', height: 'show' },
			speed: 250,
			autoArrows: false,
			dropShadows: false
		}); 
		
	}
	
	
	/*-----------------------------------------------------------------------------------*/
	/* Lavalamp Navigation effects
	/*-----------------------------------------------------------------------------------*/
		
	if ( jQuery().lavaLamp ) {
		
	    $( '.sub-menu li' ).attr( 'class', 'noLava' ); // Disable the lavalamp effect on the drop-down menu links 
	    $( '.current-menu-item, .current-menu-ancestor, .current_page_parent' ).addClass( 'selectedLava' );
	    $( "#menu > ul" ).lavaLamp({ fx: "easeOutBack", speed: 700, returnDelay: 800 });
	
	}
	
	
	/*-----------------------------------------------------------------------------------*/
	/*	Tag Hover
	/*-----------------------------------------------------------------------------------*/
		
	$( '.term-count' ).each( function() {
		$(this).css( 'marginLeft', '-' + Math.round( ($(this).outerWidth() / 2) ) + 'px' );
	});
	
	$( '#filter a' ).hover( function() {
		
		$(this).find( '.term-count' ).stop().animate({ marginBottom: '8px', opacity: 1 }, 500, 'easeInOutExpo');
		
	}, function() {
		
		$(this).find( '.term-count' ).stop().animate({ marginBottom: 0, opacity: 0 }, 500, 'easeInOutExpo');
		
	});
	
	
	/*-----------------------------------------------------------------------------------*/
	/*	Footer Overlay Widgets
	/*-----------------------------------------------------------------------------------*/
	
	var $overlayHandle = $( '#overlay-handle' );
	var $slideDiv = $('.slide-out-div');
			
	if ( $overlayHandle.length ) { 
			
		$( "#flickr .flickr_badge_image:nth-child(3n)" ).css( { 'marginRight': '0px' });	
				
		var overlayHeight = $slideDiv.height();
				
		$slideDiv.css({
			marginBottom : -overlayHeight,
			display : 'block'
		});
				
		$overlayHandle.toggle( function() {
		
			$slideDiv.animate( { marginBottom: 0 }, 700, 'easeOutCubic' );
			$(this).removeClass( 'closed' ).addClass( 'opened' );	
						
		}, function() {
			
			$slideDiv.animate( { marginBottom: -overlayHeight }, 500, 'easeOutCubic' );
			$(this).removeClass( 'opened' ).addClass( 'closed' );
						
		});
		
		// Adjust the margin of the slide out element after everything has loaded. However, do this only if the inital margin was not calculated properly
		$(window).load(function() {
			
			var newOverlayHeight = $slideDiv.height();
						
			if ( newOverlayHeight !== overlayHeight ) {
				
				if( !$overlayHandle.hasClass( 'opened' ) ) {
					$slideDiv.css({ marginBottom : -newOverlayHeight, display : 'block' });
				}
				
				overlayHeight = newOverlayHeight;
				
			}
		});
		
	}
	
	
	/*-----------------------------------------------------------------------------------*/
	/*	Scroll body to 0px on click
	/*-----------------------------------------------------------------------------------*/
	
	if ( jQuery().scrollTop ) {
		
		$('#back-to-top').topLink({
			min: 130,
			fadeSpeed: 500
		});
		
		//smoothscroll
		$('#back-to-top').click(function(e) {
			e.preventDefault();
			$.scrollTo(0, 1000, { easing: 'easeOutCubic' });
		});
	
	}
	
})( jQuery );
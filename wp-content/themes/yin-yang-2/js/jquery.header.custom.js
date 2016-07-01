/*-----------------------------------------------------------------------------------*/
/*	Custom Header JS
/*-----------------------------------------------------------------------------------*/
jQuery.noConflict();
jQuery(document).ready(function( $ ) {
		
	/*-----------------------------------------------------------------------------------*/
	/*	Ajax Call
	/*-----------------------------------------------------------------------------------*/
	
	current_post_id = '';
	var $projectWrapper = $("#project-wrapper"); 
   		
   	eQgetProjectViaAjax = function(e) {
   		   		
   		var post_id = $( this ).attr( "data-post_id" );
   		current_post_id = post_id;
      	var nonce = $( this ).attr( "data-nonce" );
      	var $prev = $( '.project-link[data-post_id="' + post_id + '"]' ).parent().parent().prev('.portfolio-item');
      	var $next = $( '.project-link[data-post_id="' + post_id + '"]' ).parent().parent().next('.portfolio-item');
      	var prev_item_id = '';
      	var next_item_id = '';
      	
      	// Get the id's of previous and next projects
      	if ( $prev.length !== 0 && $next.length !== 0 ) {
      		prev_item_id = $prev.find('.project-link').attr( "data-post_id" );
      		next_item_id = $next.find('.project-link').attr( "data-post_id" );
      	}
      	else if ( $prev.length !== 0 ) {
      		prev_item_id = $prev.find('.project-link').attr( "data-post_id" );
      	}
      	else if ( $next.length !== 0 ) {
      		next_item_id = $next.find('.project-link').attr( "data-post_id" );
      	}
      	
      	$(".single-img-loader").css( 'opacity', 1 );
	
		eQcloseProject();
			
      	$.ajax({
        	type : "post",
        	context: this,
         	dataType : "json",
         	url : headJS.ajaxurl,
         	data : {action: "eq_get_ajax_project", post_id : post_id, nonce: nonce, prev_post_id : prev_item_id, next_post_id : next_item_id},
         	beforeSend: function() {
         		// Activate the overlay over the current project
         		$( '.project-link[data-post_id="' + post_id + '"]' ).next('.blocked-project-overlay').addClass('overlay-active');
         		
         			$.scrollTo(0, 300, { easing: 'easeOutCubic' });
         		
			
         	},
         	success: function(response) {
            	$projectWrapper.html( response['html'] );
            	$projectWrapper.find('#portfolio-item-meta, #single-item').css( 'opacity', 0 );
            	
            	$("#single-item .single-img").load(function () { 
            		
            		$(this).stop().animate({ opacity: 1 }, 300); 
            		$(".single-img-loader").stop().animate({ opacity: 0 }, 300); 
            		
            	});
         	},
         	complete: function() {
				eQsliderInit();
				eQsliderNavInit();
				eQopenProject();
				$( ".prev-portfolio-post, .next-portfolio-post" ).click( eQgetProjectViaAjax );
				$( '.prev-portfolio-post, .next-portfolio-post' ).click( showLoaderImg );
				$( ".close-current-post" ).click( eQcloseProject );				
				$( '#overlay' ).fadeOut(500);
				$projectWrapper.find('#portfolio-item-meta, #single-item').stop().animate({ opacity: 1 }, 400);
			}
      	});
      	
      	e.preventDefault();
   		
   	}
   	
   	if ( !$( 'body' ).hasClass('ie8') ) {
   			
   		$( ".project-link" ).click( eQgetProjectViaAjax );
   		
   		$( "#flickr .flickr_badge_image:nth-child(3n)" ).css( { 'marginRight': '0px' }); // Set the margins for flickr images, if included

   	} // end "IE8" if 
		   	
   	function eQcloseProject() {
   		
   		var $clickedObject = $(this);
   		
   		// If the project was closed by clicking the close (x) button, add the "closed-project" class to the div wrapper that holds the ajax projects, so that the portfolio filter
   		// doesn't activate the overlay for the closed project, when the filtering animation ends. 
   		if( $clickedObject.hasClass('close-current-post') ) {
   			$projectWrapper.addClass('closed-project');
   		}
   		
   		// Remove the overlay from the current project that is being closed
   		$('.blocked-project-overlay').removeClass('overlay-active');
					
		$projectWrapper.find('#portfolio-item-meta, #single-item').stop().animate({
			opacity: 0
		}, 200);
			
		$projectWrapper.stop().animate({
			height: 0
		}, 600, 'easeOutQuart', function() {
			$(this).css('overflow', 'hidden');
			
			if( $clickedObject.hasClass('close-current-post') ) {
   				$(this).empty();
   			}
		});
		
	}
	
	function eQopenProject() {
		
		var projectHeight = 0;
		var leftColHeight = ( $( '#single-item img:first-child' ).length ) ? $('#single-item img:first-child').outerHeight() : $('#single-item iframe').outerHeight();
		var rightColHeight = $('#portfolio-item-meta').outerHeight( true );	
		
		if( !$( '#single-item img:first-child' ).length && !$( '#single-item iframe' ).length ) {
			leftColHeight = $( '#single-item *[height]:first-child' ).outerHeight();
		}
				
		// add the bottom margin for the slider, in the project height calculation, if the slider is present; otherwise, add 10 pixels to adjust the height for the bottom margin
		if( $( '#single-item .slider' ).length ) {
			leftColHeight += 40; 
		}
		else {
			leftColHeight += 43;
		}
		
		leftColHeight += $( '#single-item .item-description' ).outerHeight( true );
		
		if( $projectWrapper.hasClass( 'closed-project' ) ) {
			$projectWrapper.removeClass( 'closed-project' );	
		}
				
		projectHeight = ( leftColHeight >= rightColHeight) ? leftColHeight : rightColHeight; 
		projectHeight += $( '.portfolio-border' ).outerHeight( true ); 						
								
		$projectWrapper.animate({
			height: projectHeight
		}, 800, 'easeOutQuart', function() {
			$(this).css({ 'overflow': 'visible', 'height': 'auto' });
		});
		
	}
   	
    
   	/*-----------------------------------------------------------------------------------*/
	/*	Portfolio Slider
	/*-----------------------------------------------------------------------------------*/
	
   	function eQsliderInit() {
   		
	   	if( jQuery().slides ) {
			$( "#slides" ).slides({ 
				preload: true, 
				preloadImage: headJS.templateurl + "/images/layout/loading.gif", 
				play: 0, 
				pause: 2500, 
				slideEasing: 'easeOutSine', 
				fadeEasing: 'easeOutSine', 
				hoverPause: true, 
				container: 'slides-container', 
				pagination: true, 
				generatePagination: true, 
				fadeSpeed: 350, 
				slideSpeed: 350, 
				autoHeight: true, 
				autoHeightSpeed: 350, 
				effect: "slide", 
				crossfade: true, 
				randomize: false, 
				start: 1,
				bigTarget: true
			});
		}
		
	}
	
	
	/*-----------------------------------------------------------------------------------*/
	/*	Drop-down Page
	/*-----------------------------------------------------------------------------------*/
	
	if ( jQuery().scrollTop ) {
		
		var $dropDownWrapper = $( '#dropdown-wrapper' );
		
		if ( $dropDownWrapper.length ) { 
				
			$('#dropdown-trigger').click(function() {
				
				var pageHeight = $('.dropdown-page').height() + 60; // Get the height, while including the top and bottom padding of the drop-down page
				var wrapperHeight = $dropDownWrapper.height();	
					
				// Animate the height of the wrapper, depending on the current state (visible or not)			
				if( wrapperHeight == 0 ) {
					$('.drop-down-arrows').css('backgroundPosition', 'left top');
					$dropDownWrapper.animate( { height: pageHeight }, 700, 'easeOutCubic', function() {
						$(this).css('height', 'auto');	
					});
				}
				else {
					$('.drop-down-arrows').css('backgroundPosition', '0px -13px');
					$dropDownWrapper.animate( { height: 0 }, 500, 'easeOutCubic' );
				}
				
				$( 'body, html' ).animate({ scrollTop: 0 }, 200, 'easeOutCubic' );
				
			});
			
			// Replace the default ajax loader gif, with another image, if the contact form shortcode has been executed within the drop-down page
			if ( $( '#dropdown-wrapper .loading-img' ).length ) { 
				$( '#dropdown-wrapper .loading-img' ).attr('src', headJS.themePath + '/images/layout/ajax-loader.gif');
			}
		}
	
	}
	
	
	/*-----------------------------------------------------------------------------------*/
	/*	Project Loader Image
	/*-----------------------------------------------------------------------------------*/
	
	function showLoaderImg() {
		$( '#overlay' ).css('visibility', 'visible');
		$( '#overlay' ).fadeIn(500);
	}
	
	$( '.project-link, .project-title a, .share-this a[rel="next"], .share-this a[rel="prev"]' ).click( showLoaderImg );
	
	
	/*-----------------------------------------------------------------------------------*/
	/*	Item Hover Effect
	/*-----------------------------------------------------------------------------------*/
	
	var portfolioItems = '.project-overlay';
	
	if ( jQuery().scrollTop ) {
	
		if ( !Modernizr.csstransitions ) {
			portfolioItems = '.project-overlay, .view-button, .project-caption';
		}
		
		if ( !Modernizr.csstransitions ) {
			oyItemHoverEffectInit = function() {
				
				var hoverOverFunction = function() {
					var $this = $( this );
					
					if( $this.is( 'h3' ) ) {
						$this = $( this ).prev();
					}
					
					if ( !$( 'body' ).hasClass('ie8') ) {			
						$this.find( portfolioItems ).stop().animate( { opacity: 1 }, 300, 'easeInOutExpo' );
					}
					else {
						$this.find( portfolioItems ).stop().animate( { opacity: 0.92 }, 300, 'easeInOutExpo' );
					}
				} 
							
				var hoverOutFunction = function() {
					var $this = $( this );
					
					if( $this.is( 'h3' ) ) {
						$this = $( this ).prev();
					}
					
					$this.find( portfolioItems ).stop().animate( { opacity: 0 }, 500, 'easeInOutCubic' );			
				}
							
				$('.project-link, .project-link + h3').hover( hoverOverFunction, hoverOutFunction);
				
			}
			
			oyItemHoverEffectInit();
		}
		
	}

	
	/*-----------------------------------------------------------------------------------*/
	/*	Slider Next Prev Navigation
	/*-----------------------------------------------------------------------------------*/
	
	function eQsliderNavInit() {
		
		var $navLinksDiv = $( '#slides #next-prev-links img' );
		
		
		var sliderHoverOverFunction = function() {
			if ( !$( 'body' ).hasClass('ie8') ) {
				$navLinksDiv.stop().animate( { opacity: 0.5 }, 200, 'easeInOutExpo' );
			}
			else {
				$navLinksDiv.css('visibility', 'visible');
			}
		} 
		
		var sliderHoverOutFunction = function() {
			if ( !$( 'body' ).hasClass('ie8') ) {
				$navLinksDiv.stop().animate({ opacity: 0 }, 450, 'easeInOutCubic');			
			}
			else {
				$navLinksDiv.css('visibility', 'hidden');
			}	
		} 
	
		$( '.slider' ).hover( sliderHoverOverFunction, sliderHoverOutFunction );
	
	}
	
	
	/*-----------------------------------------------------------------------------------*/
	/*	single-portfolio.php
	/*-----------------------------------------------------------------------------------*/
	
	eQsliderInit();
	eQsliderNavInit();
	
	$( ".close-current-post, .prev-portfolio-post, .next-portfolio-post" ).click( function() {
		
		if ( !$( 'body' ).hasClass('ie8') ) {
			
			var $clickedObject = $(this);
			
			if( $clickedObject.hasClass('close-current-post') ) {
	   			$projectWrapper.addClass('closed-project');
	   		}
	   		
			$('.blocked-project-overlay').css('display', 'none');
						
			$projectWrapper.find('#portfolio-item-meta, #single-item').stop().animate({
				opacity: 0
			}, 200);
				
			$projectWrapper.stop().animate({
				height: 0
			}, 600, 'easeOutQuart', function() {
				$(this).css('overflow', 'hidden');
				
				if( $clickedObject.hasClass('close-current-post') ) {
   					$(this).empty();
   				}
			});
		
		}
		
	});
	
	if ( !$( 'body' ).hasClass('ie8') ) {
		$( ".prev-portfolio-post, .next-portfolio-post" ).click( eQgetProjectViaAjax );	
	}
	
	$( '.prev-portfolio-post, .next-portfolio-post' ).click( showLoaderImg );
	
	
	/*-----------------------------------------------------------------------------------*/
	/*	ToolTips
	/*-----------------------------------------------------------------------------------*/

	/* blog post tooltips */
	$( '.share-this a[rel="next"]' ).attr('title', headJS.prevPost);
	$( '.share-this a[rel="prev"]' ).attr('title', headJS.nextPost);
	
});
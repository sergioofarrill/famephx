jQuery(document).ready(function( $ ) {
		
	// Get the action filter option item on page load
	var $filterType = $( "#filter li.active a" ).attr( "class" ); 
	
	// Get and assign the ourHolder element to the
	// $holder varible for use later
	var $holder = $("#filterable-gallery"); 
	
	// Clone all items within the pre-assigned $holder element
	var $data = $holder.clone(); 
		
	// Attempt to call Quicksand when a filter option
	// item is clicked
	$( "#filter li a" ).click( function(e) { 
				
		// Reset the active class on all the buttons
		$( "#filter li" ).removeClass( "active" ); 
		var items_per_row = 4;
		
		// assign the class of the clicked filter option
		// element to our $filterType variable
		var $filterType = $(this).attr("class").split(" ")[0]; 
		$(this).parent().addClass("active"); 
		
		if ($filterType == "all") { 
			// assign all li items to the $filteredData var when
			// the 'All' filter option is clicked
			var $filteredData = $data.find("li[data-group]"); 
			var i = 1; 
			
			$filteredData.each(function() {
				var $self = $(this);
				$self.removeClass("alpha omega");
				
				if(i === 1) {
					$self.addClass("alpha");
				}
				else if( i === items_per_row ) {
					$self.addClass("omega");
				}
				
				if ( i === items_per_row ) {
					i = 1;
				}
				else {
					i++;
				}
			});
		
		}
		else {
			// find all li elements that have our required $filterType
			// values for the data-type element
			var $filteredData = $data.find("li[data-group*=" + $filterType + "]");
			var i = 1;
			
			$filteredData.each(function() {
				var $self = $(this);
				$self.removeClass("alpha omega");
				
				if ( i === 1 ) {
					$self.addClass("alpha");
				}
				else if ( i === items_per_row ) {
					var $html = $self.html();
					$self.addClass("omega");
				}
				
				if( i === items_per_row ) {
					i = 1;
				}
				else {
					i++;
				}
			});
		}
		
		$holder.quicksand($filteredData, {
			duration: 800,
			easing: "easeInOutQuad",
			enhancement: function() {
				if ( !$("#project-wrapper").hasClass( 'closed-project' ) || $( 'body' ).hasClass('ie8') ) {
					$( '.project-link[data-post_id="' + current_post_id + '"]' ).next('.blocked-project-overlay').addClass('overlay-active');	
				}
	        }
		}, function() { // Callback 
						
			$( '.project-link' ).click( function() {
				$( '#overlay' ).css('visibility', 'visible');
				$( '#overlay' ).fadeIn(500);
			});
			
			if ( !$( 'body' ).hasClass('ie8') ) {			
				$( ".project-link" ).click( eQgetProjectViaAjax );	
			}
			
			if ( !Modernizr.csstransitions ) {				
				oyItemHoverEffectInit();
			}
									
		});
		return false;
	});

});
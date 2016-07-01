
jQuery(document).ready(function($) {



/*
 * Plugin Name: jQuery Tab Slider
 * Version: 1.0
 * Author: Geoffrey Rickaby
 * Author URL: http://www.geoffreyrickaby.com/jQueryPlugins/Tab-Slider
 * License: GNU General Public License, version 3 (GPL-3.0)
 * 
 */


    var $width = 940, //The width in pixels of your #tab-slider 
        $tabs = $('.tab'), //Your Navigation Class Name
        $delay = 700; // Pause time between animation in Milliseconds
   
 $('.tab-slider-wrapper').css({width: $tabs.length * $width});
 $('a.tab-link').click(function() {$tabs.removeClass('active');
 $(this).parent().addClass('active');
 var $contentNum = parseInt($(this).attr('rel'), 10);
 $('.tab-slider-wrapper').animate({marginLeft: '-' + ($width * $contentNum - $width)}, $delay);return false;});
 


//*	JSON NEWS FEED


	$(function() {

	  var MCnews = // REMOVE COMMENT TO ACTIVATE FEED "http://mcsaatchi.com/cms/api/news"; //src of json feed

		$.getJSON( MCnews,function(data) { // convert into javascript object (data holds the json object)
		     
		    var e = [data.current.collection]; //Dig into the Json to where the news items are
		    var h = []							//store the news items into an array with a for loop

			for (var i = 0; i < e.length; i++) {
			    h.push.apply(h, e[i]);
				}

			// get the items from the var where we stored them iterate through the returned data ($.each), build a list and .append to DOM
			//SLICE THE NUMBER OF ITEMS TO DISPLAY default = (1,4)
			$.each(h.slice(2,3), function (i, items) {
		    
			$('<li class="news_item"><a href="#lbp-inline-href-' + i + '" class="lbp-inline-link-' + i + '"><h2 class="name" itemprop="title">' + items.title + '</h2><br><p>Read More...</p></a> </li>')
		   .appendTo('ul#news_title');
		  	content = $('<div style="display: none;"><div id="lbp-inline-href-' + i + '" class="light_txt" ><div class="article__slideshow"><img src="javascript:void(0)" class="article_img article__image--fit" style="background-image:url(' + items.image + ');"/></div><article class="article_info"><h2 class="article__title--small"> ' + items.title + ' </h2><p><strong> ' + items.date +' </strong></p>  <span >' + items.body + '</span></article></div></div>')
		   .appendTo('div#theNews');
		 
		});
 			
 		console.log( h );

    //*****ADD FANCYBOX FOR LINK HERE*****
		 	
		})

	}); //END JSON NEWS FEED

//* FANCY BOX FOR NEWS LINKS (MOVE INTO *****NEWS FEED***** TO WORK ON JSON ITEMS WHEN JSON FEED IS ACTIVE)

  $(".news_item a, .hspot_press, .featured_article ").on('click', function(event) {
       var clickedId= $(this).attr("class"); //store the clicked class in var
         
         $("a." + clickedId).fancybox( //fancybox code and options set to trigger on the clickes class
          
          {
          'type'      : 'inline',
          'width'     : '100%',
          'height'    : '100%',
          'overflow'    : 'hidden',
          'autoSize'    : false,
        'transitionIn'  : 'elastic',
        'transitionOut' : 'elastic',
        'speedIn'   : 600, 
        'speedOut'    : 200, 
        'overlayShow' : true, 
        'beforeShow'  : function() {
              $('.fancybox-overlay').css(
              {
              
              'background-image'  : 'none',
              'background-color'  : '#FFF'
              });
              $("body").css({'overflow-y':'hidden', 'height':'200px'});
          },
          'afterClose'  : function(){
          $("body").css({'overflow-y':'visible', 'height':'100%'});
        }
        
      }); 
      console.log("#" + clickedId);
     });


	

//TEAM SECTION FANCYBOX



	/* This is basic - uses default settings */
	
	$("a#team").fancybox();
	
	/* Using custom settings */
	
	$("a#inline").fancybox({
		'hideOnContentClick': true
	});

	/* Apply fancybox to multiple items */
	
	$("a.group").fancybox({
		'transitionIn'	:	'fade',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	250, 
		'overlayShow'	:	true
	});
	


//LOGO TABS

$(function() {
    $('#Logo-1-trigger').toggle(function() { 
       $('#Logo-1').fadeIn("slow");
  return false; 
    }, function() {  
    });
});




$(function() {
    $('#Logo-1-trigger').toggle(function(){ 
       $('#Logo-1').fadeIn("slow"); 
   return false; 
     }, function() { 
       $('#Logo-7').fadeOut("slow"); 
return false; 
   });
});

$(function() {
    $('#Logo-1-trigger').toggle(function() { 
        $('#Logo-7').fadeOut("slow");
return false;  
    }, function() { 
       $('#Logo-1').fadeIn("slow");
return false; 
    });
});



$(function() {
    $('#Logo-1-trigger').toggle(function(){ 
        $('#Logo-1').fadeIn("slow");
return false;  
     }, function() { 
       $('#Logo-6').fadeOut("slow");
return false;  
   });
});

$(function() {
    $('#Logo-1-trigger').toggle(function(){ 
        $('#Logo-6').fadeOut("slow");
return false; 
     }, function() { 
       $('#Logo-1').fadeIn("slow"); 
return false;  
   });
});



$(function() {
    $('#Logo-1-trigger').toggle(function(){ 
        $('#Logo-1').fadeIn("slow"); 
  return false;
     }, function() { 
       $('#Logo-5').fadeOut("slow");
  return false;  
   });
});

$(function() {
    $('#Logo-1-trigger').toggle(function(){ 
        $('#Logo-5').fadeOut("slow");
  return false; 
     }, function() { 
        $('#Logo-1').fadeIn("slow"); 
  return false;  
   });
});



$(function() {
    $('#Logo-1-trigger').toggle(function(){ 
       $('#Logo-1').fadeIn("slow");  
     }, function() { 
       $('#Logo-3').fadeOut("slow"); 
   });
});

$(function() {
    $('#Logo-1-trigger').toggle(function(){ 
        $('#Logo-3').fadeOut("slow"); 
  return false;
     }, function() { 
        $('#Logo-1').fadeIn("slow");  
  return false; 
   });
});



$(function() {
    $('#Logo-1-trigger').toggle(function(){ 
        $('#Logo-1').fadeIn("slow"); 
  return false;
     }, function() { 
       $('#Logo-4').fadeOut("slow"); 
  return false;
   });
});

$(function() {
    $('#Logo-1-trigger').toggle(function() { 
        $('#Logo-4').fadeOut("slow"); 
  return false;
    }, function() { 
        $('#Logo-1').fadeIn("slow");
  return false;  
    });
});


$(function() {
    $('#Logo-1-trigger').toggle(function(){ 
         $('#Logo-1').fadeIn("slow"); 
  return false; 
     }, function() { 
       $('#Logo-2').fadeOut("slow");
  return false; 
   });
});

$(function() {
    $('#Logo-2-trigger').toggle(function() { 
        $('#Logo-2').fadeOut("slow");
  return false; 
    }, function() { 
         $('#Logo-1').fadeIn("slow");
  return false; 
    });
});




$(function() {
    $('#Logo-1-trigger').toggle(function(){ 
        $('#Logo-1').fadeIn("slow");
  return false;
     }, function() { 
       $('#Logo-0').fadeOut("slow"); 
  return false;
   });
});

$(function() {
    $('#Logo-1-trigger').toggle(function() { 
        $('#Logo-0').fadeOut("slow"); 
  return false;
    }, function() { 
        $('#Logo-1').fadeIn("slow"); 
  return false;
    });
});



$(function() {
    $('#Logo-2-trigger').toggle(function() { 
        $('#Logo-2').fadeIn("slow");
      return false;  
    }, function() {  
    });
});



$(function() {
    $('#Logo-2-trigger').toggle(function(){ 
        $('#Logo-2').fadeIn("slow"); 
  return false; 
     }, function() { 
       $('#Logo-7').fadeOut("slow"); 
 return false;  
   });
});

$(function() {
    $('#Logo-2-trigger').toggle(function() { 
        $('#Logo-7').fadeOut("slow");  
    }, function() { 
        $('#Logo-2').fadeIn("slow"); 
    });
});



$(function() {
    $('#Logo-2-trigger').toggle(function(){ 
        $('#Logo-2').fadeIn("slow"); 
 return false; 
     }, function() { 
       $('#Logo-6').fadeOut("slow"); 
 return false;  
   });
});

$(function() {
    $('#Logo-2-trigger').toggle(function(){ 
        $('#Logo-6').fadeOut("slow"); 
 return false; 
     }, function() { 
       $('#Logo-2').fadeIn("slow");  
 return false; 
   });
});



$(function() {
    $('#Logo-2-trigger').toggle(function(){ 
        $('#Logo-2').fadeIn("slow"); 
 return false; 
     }, function() { 
       $('#Logo-5').fadeOut("slow");  
 return false; 
   });
});

$(function() {
    $('#Logo-2-trigger').toggle(function(){ 
        $('#Logo-5').fadeOut("slow"); 
 return false; 
     }, function() { 
       $('#Logo-2').fadeIn("slow"); 
 return false; 
   });
});



$(function() {
    $('#Logo-2-trigger').toggle(function(){ 
        $('#Logo-2').fadeIn("slow"); 
 return false; 
     }, function() { 
       $('#Logo-3').fadeOut("slow"); 
 return false; 
   });
});

$(function() {
    $('#Logo-2-trigger').toggle(function(){ 
        $('#Logo-3').fadeOut("slow"); 
     }, function() { 
       $('#Logo-2').fadeIn("slow");   
   });
});





$(function() {
    $('#Logo-2-trigger').toggle(function(){ 
        $('#Logo-2').fadeIn("slow");  
 return false; 
     }, function() { 
       $('#Logo-4').fadeOut("slow");  
   });
});

$(function() {
    $('#Logo-2-trigger').toggle(function() { 
        $('#Logo-4').fadeOut("slow"); 
 return false;  
    }, function() { 
        $('#Logo-2').fadeIn("slow");
 return false;  
    });
});





$(function() {
    $('#Logo-2-trigger').toggle(function(){ 
        $('#Logo-2').fadeIn("slow");
 return false;  
     }, function() { 
       $('#Logo-1').fadeOut("slow");  
 return false; 
   });
});

$(function() {
    $('#Logo-2-trigger').toggle(function() { 
        $('#Logo-1').fadeOut("slow");
 return false;  
    }, function() { 
        $('#Logo-2').fadeIn("slow"); 
 return false; 
    });
});




$(function() {
    $('#Logo-2-trigger').toggle(function(){ 
        $('#Logo-2').fadeIn("slow"); 
 return false; 
     }, function() { 
       $('#Logo-0').fadeOut("slow");  
 return false; 
   });
});

$(function() {
    $('#Logo-2-trigger').toggle(function() { 
        $('#Logo-0').fadeOut("slow"); 
 return false; 
    }, function() { 
        $('#Logo-2').fadeIn("slow");   
 return false; 
    });
});



$(function() {
    $('#Logo-3-trigger').toggle(function() { 
        $('#Logo-3').fadeIn("slow"); 
    }, function() {  
    });
});







$(function() {
    $('#Logo-3-trigger').toggle(function(){ 
        $('#Logo-3').fadeIn("slow"); 
     }, function() { 
       $('#Logo-7').fadeOut("slow");  
   });
});

$(function() {
    $('#Logo-3-trigger').toggle(function() { 
        $('#Logo-7').fadeOut("slow"); 
    }, function() { 
        $('#Logo-3').fadeIn("slow"); 
    });
});





$(function() {
    $('#Logo-3-trigger').toggle(function(){ 
        $('#Logo-3').fadeIn("slow"); 
     }, function() { 
       $('#Logo-6').fadeOut("slow");  
   });
});

$(function() {
    $('#Logo-3-trigger').toggle(function(){ 
        $('#Logo-6').fadeOut("slow"); 
     }, function() { 
       $('#Logo-3').fadeIn("slow");   
   });
});





$(function() {
    $('#Logo-3-trigger').toggle(function(){ 
        $('#Logo-3').fadeIn("slow"); 
     }, function() { 
       $('#Logo-5').fadeOut("slow");  
   });
});

$(function() {
    $('#Logo-3-trigger').toggle(function(){ 
        $('#Logo-5').fadeOut("slow"); 
     }, function() { 
       $('#Logo-3').fadeIn("slow");   
   });
});




$(function() {
    $('#Logo-3-trigger').toggle(function(){ 
        $('#Logo-3').fadeIn("slow"); 
     }, function() { 
       $('#Logo-4').fadeOut("slow"); 
   });
});

$(function() {
    $('#Logo-3-trigger').toggle(function(){ 
        $('#Logo-4').fadeOut("slow"); 
     }, function() { 
       $('#Logo-3').fadeIn("slow");   
   });
});



$(function() {
    $('#Logo-3-trigger').toggle(function(){ 
        $('#Logo-3').fadeIn("slow"); 
     }, function() { 
       $('#Logo-2').fadeOut("slow");  
   });
});

$(function() {
    $('#Logo-3-trigger').toggle(function() { 
        $('#Logo-2').fadeOut("slow"); 
    }, function() { 
        $('#Logo-3').fadeIn("slow"); 
    });
});





$(function() {
    $('#Logo-3-trigger').toggle(function(){ 
        $('#Logo-3').fadeIn("slow"); 
     }, function() { 
       $('#Logo-1').fadeOut("slow"); 
   });
});

$(function() {
    $('#Logo-4-trigger').toggle(function() { 
        $('#Logo-1').fadeOut("slow"); 
    }, function() { 
        $('#Logo-3').fadeIn("slow"); 
    });
});




$(function() {
    $('#Logo-3-trigger').toggle(function(){ 
        $('#Logo-3').fadeIn("slow");  
     }, function() { 
       $('#Logo-0').fadeOut("slow");  
   });
});

$(function() {
    $('#Logo-3-trigger').toggle(function() { 
        $('#Logo-0').fadeOut("slow"); 
    }, function() { 
        $('#Logo-3').fadeIn("slow"); 
    });
});




$(function() {
    $('#Logo-4-trigger').toggle(function() { 
        $('#Logo-4').fadeIn("slow"); 
    }, function() {  
    });
});







$(function() {
    $('#Logo-4-trigger').toggle(function(){ 
        $('#Logo-4').fadeIn("slow"); 
     }, function() { 
       $('#Logo-7').fadeOut("slow");  
   });
});

$(function() {
    $('#Logo-4-trigger').toggle(function() { 
        $('#Logo-7').fadeOut("slow"); 
    }, function() { 
        $('#Logo-4').fadeIn("slow"); 
    });
});





$(function() {
    $('#Logo-4-trigger').toggle(function(){ 
        $('#Logo-4').fadeIn("slow");  
     }, function() { 
       $('#Logo-6').fadeOut("slow");   
   });
});

$(function() {
    $('#Logo-4-trigger').toggle(function(){ 
        $('#Logo-6').fadeOut("slow"); 
     }, function() { 
       $('#Logo-4').fadeIn("slow");  
   });
});





$(function() {
    $('#Logo-4-trigger').toggle(function(){ 
        $('#Logo-4').fadeIn("slow");  
     }, function() { 
       $('#Logo-5').fadeOut("slow");  
   });
});

$(function() {
    $('#Logo-4-trigger').toggle(function(){ 
        $('#Logo-5').fadeOut("slow"); 
     }, function() { 
       $('#Logo-4').fadeIn("slow"); 
   });
});





$(function() {
    $('#Logo-4-trigger').toggle(function(){ 
        $('#Logo-4').fadeIn("slow");  
     }, function() { 
       $('#Logo-3').fadeOut("slow");  
   });
});

$(function() {
    $('#Logo-4-trigger').toggle(function(){ 
        $('#Logo-3').fadeOut("slow");
     }, function() { 
       $('#Logo-4').fadeIn("slow");  
   });
});





$(function() {
    $('#Logo-4-trigger').toggle(function(){ 
        $('#Logo-4').fadeIn("slow");  
     }, function() { 
       $('#Logo-2').fadeOut("slow");
   });
});

$(function() {
    $('#Logo-4-trigger').toggle(function() { 
        $('#Logo-2').fadeOut("slow");
    }, function() { 
        $('#Logo-4').fadeIn("slow");  
    });
});





$(function() {
    $('#Logo-4-trigger').toggle(function(){ 
        $('#Logo-4').fadeIn("slow"); 
     }, function() { 
       $('#Logo-1').fadeOut("slow");   
   });
});

$(function() {
    $('#Logo-4-trigger').toggle(function() { 
        $('#Logo-1').fadeOut("slow");  
    }, function() { 
        $('#Logo-4').fadeIn("slow");  
    });
});




$(function() {
    $('#Logo-4-trigger').toggle(function(){ 
        $('#Logo-4').fadeIn("slow"); 
     }, function() { 
       $('#Logo-0').fadeOut("slow");   
   });
});

$(function() {
    $('#Logo-4-trigger').toggle(function() { 
        $('#Logo-0').fadeOut("slow");
    }, function() { 
        $('#Logo-4').fadeIn("slow");  
    });
});




$(function() {
    $('#Logo-5-trigger').toggle(function() { 
        $('#Logo-5').fadeIn("slow");  
    }, function() {  
    });
});







$(function() {
    $('#Logo-5-trigger').toggle(function(){ 
        $('#Logo-5').fadeIn("slow"); 
     }, function() { 
       $('#Logo-7').fadeOut("slow"); 
   });
});

$(function() {
    $('#Logo-5-trigger').toggle(function() { 
        $('#Logo-7').fadeOut("slow");  
    }, function() { 
        $('#Logo-5').fadeIn("slow"); 
    });
});





$(function() {
    $('#Logo-5-trigger').toggle(function(){ 
        $('#Logo-5').fadeIn("slow"); 
     }, function() { 
       $('#Logo-6').fadeOut("slow");   
   });
});

$(function() {
    $('#Logo-5-trigger').toggle(function(){ 
        $('#Logo-6').fadeOut("slow"); 
     }, function() { 
       $('#Logo-5').fadeIn("slow");  
   });
});




$(function() {
    $('#Logo-5-trigger').toggle(function(){ 
        $('#Logo-5').fadeIn("slow"); 
     }, function() { 
       $('#Logo-4').fadeOut("slow");  
   });
});

$(function() {
    $('#Logo-5-trigger').toggle(function(){ 
        $('#Logo-4').fadeOut("slow"); 
     }, function() { 
       $('#Logo-5').fadeIn("slow");  
   });
});




$(function() {
    $('#Logo-5-trigger').toggle(function(){ 
        $('#Logo-5').fadeIn("slow"); 
     }, function() { 
       $('#Logo-3').fadeOut("slow"); 
   });
});

$(function() {
    $('#Logo-5-trigger').toggle(function() { 
        $('#Logo-3').fadeOut("slow"); 
    }, function() { 
        $('#Logo-5').fadeIn("slow");  
    });
});




$(function() {
    $('#Logo-5-trigger').toggle(function(){ 
        $('#Logo-5').fadeIn("slow");  
     }, function() { 
       $('#Logo-2').fadeOut("slow"); 
   });
});

$(function() {
    $('#Logo-5-trigger').toggle(function() { 
        $('#Logo-2').fadeOut("slow");  
    }, function() { 
        $('#Logo-5').fadeIn("slow");  
    });
});





$(function() {
    $('#Logo-5-trigger').toggle(function(){ 
        $('#Logo-5').fadeIn("slow"); 
     }, function() { 
       $('#Logo-1').fadeOut("slow"); 
   });
});

$(function() {
    $('#Logo-5-trigger').toggle(function() { 
        $('#Logo-1').fadeOut("slow"); 
    }, function() { 
        $('#Logo-5').fadeIn("slow");  
    });
});




$(function() {
    $('#Logo-5-trigger').toggle(function(){ 
        $('#Logo-5').fadeIn("slow");  
     }, function() { 
       $('#Logo-0').fadeOut("slow");   
   });
});

$(function() {
    $('#Logo-5-trigger').toggle(function() { 
        $('#Logo-0').fadeOut("slow");  
    }, function() { 
        $('#Logo-5').fadeIn("slow"); 
    });
});




$(function() {
    $('#Logo-6-trigger').toggle(function() { 
        $('#Logo-6').fadeIn("slow");  
    }, function() {  
    });
});





$(function() {
    $('#Logo-6-trigger').toggle(function(){ 
        $('#Logo-6').fadeIn("slow"); 
     }, function() { 
       $('#Logo-7').fadeOut("slow"); 
   });
});

$(function() {
    $('#Logo-6-trigger').toggle(function(){ 
        $('#Logo-7').fadeOut("slow");  
     }, function() { 
       $('#Logo-6').fadeIn("slow");   
   });
});




$(function() {
    $('#Logo-6-trigger').toggle(function(){ 
        $('#Logo-6').fadeIn("slow"); 
     }, function() { 
       $('#Logo-5').fadeOut("slow"); 
   });
});

$(function() {
    $('#Logo-6-trigger').toggle(function(){ 
        $('#Logo-5').fadeOut("slow"); 
     }, function() { 
       $('#Logo-6').fadeIn("slow");  
   });
});




$(function() {
    $('#Logo-6-trigger').toggle(function(){ 
        $('#Logo-6').fadeIn("slow");  
     }, function() { 
       $('#Logo-4').fadeOut("slow");   
   });
});

$(function() {
    $('#Logo-6-trigger').toggle(function() { 
        $('#Logo-4').fadeOut("slow"); 
    }, function() { 
        $('#Logo-6').fadeIn("slow");  
    });
});




$(function() {
    $('#Logo-6-trigger').toggle(function(){ 
        $('#Logo-6').fadeIn("slow"); 
     }, function() { 
       $('#Logo-3').fadeOut("slow");  
   });
});

$(function() {
    $('#Logo-6-trigger').toggle(function() { 
        $('#Logo-3').fadeOut("slow");  
    }, function() { 
        $('#Logo-6').fadeIn("slow");  
    });
});





$(function() {
    $('#Logo-6-trigger').toggle(function(){ 
        $('#Logo-6').fadeIn("slow");  
     }, function() { 
       $('#Logo-2').fadeOut("slow"); 
   });
});

$(function() {
    $('#Logo-6-trigger').toggle(function() { 
        $('#Logo-2').fadeOut("slow"); 
    }, function() { 
        $('#Logo-6').fadeIn("slow");  
    });
});




$(function() {
    $('#Logo-6-trigger').toggle(function(){ 
        $('#Logo-6').fadeIn("slow");  
     }, function() { 
       $('#Logo-1').fadeOut("slow");  
   });
});

$(function() {
    $('#Logo-6-trigger').toggle(function() { 
        $('#Logo-1').fadeOut("slow");
    }, function() { 
        $('#Logo-6').fadeIn("slow");  
    });
});





$(function() {
    $('#Logo-6-trigger').toggle(function(){ 
        $('#Logo-6').fadeIn("slow"); 
     }, function() { 
       $('#Logo-0').fadeOut("slow"); 
   });
});

$(function() {
    $('#Logo-6-trigger').toggle(function() { 
        $('#Logo-0').fadeOut("slow");  
    }, function() { 
        $('#Logo-6').fadeIn("slow"); 
    });
});




$(function() {
    $('#Logo-7-trigger').toggle(function() { 
        $('#Logo-7').fadeIn("slow"); 
    }, function() {     
    });
});




$(function() {
    $('#Logo-7-trigger').toggle(function(){ 
        $('#Logo-7').fadeIn("slow"); 
     }, function() { 
       $('#Logo-6').fadeOut("slow");  
   });
});


$(function() {
    $('#Logo-7-trigger').toggle(function() { 
        $('#Logo-6').fadeOut("slow"); 
    }, function() { 
        $('#Logo-7').fadeIn("slow");  
    });
});




$(function() {
    $('#Logo-7-trigger').toggle(function(){ 
        $('#Logo-7').fadeIn("slow"); 
     }, function() { 
       $('#Logo-5').fadeOut("slow");  
   });
});


$(function() {
    $('#Logo-7-trigger').toggle(function() { 
        $('#Logo-5').fadeOut("slow"); 
    }, function() { 
        $('#Logo-7').fadeIn("slow"); 
    });
});




$(function() {
    $('#Logo-7-trigger').toggle(function(){ 
        $('#Logo-7').fadeIn("slow"); 
     }, function() { 
       $('#Logo-4').fadeOut("slow"); 
   });
});

$(function() {
    $('#Logo-7-trigger').toggle(function() { 
        $('#Logo-4').fadeOut("slow");  
    }, function() { 
        $('#Logo-7').fadeIn("slow");  
    });
});




$(function() {
    $('#Logo-7-trigger').toggle(function(){ 
        $('#Logo-7').fadeIn("slow");  
     }, function() { 
       $('#Logo-3').fadeOut("slow");   
   });
});

$(function() {
    $('#Logo-7-trigger').toggle(function() { 
        $('#Logo-3').fadeOut("slow");  
    }, function() { 
        $('#Logo-7').fadeIn("slow"); 
    });
});



$(function() {
    $('#Logo-7-trigger').toggle(function(){ 
        $('#Logo-7').fadeIn("slow"); 
     }, function() { 
       $('#Logo-2').fadeOut("slow");  
   });
});

$(function() {
    $('#Logo-7-trigger').toggle(function() { 
        $('#Logo-2').fadeOut("slow");  
    }, function() { 
        $('#Logo-7').fadeIn("slow"); 
    });
});




$(function() {
    $('#Logo-7-trigger').toggle(function(){ 
        $('#Logo-7').fadeIn("slow");  
     }, function() { 
       $('#Logo-1').fadeOut("slow");  
   });
});

$(function() {
    $('#Logo-7-trigger').toggle(function() { 
        $('#Logo-1').fadeOut("slow");  
    }, function() { 
        $('#Logo-7').fadeIn("slow");  
    });
});





$(function() {
    $('#Logo-7-trigger').toggle(function(){ 
        $('#Logo-7').fadeIn("slow"); 
     }, function() { 
       $('#Logo-0').fadeOut("slow");  
   });
});

$(function() {
    $('#Logo-7-trigger').toggle(function() { 
        $('#Logo-0').fadeOut("slow");  
    }, function() { 
        $('#Logo-7').fadeIn("slow"); 
    });
});

// MAP SCRIPT

    $('.map1').hide().before('<a href="#" id="open-map1" class="button-1"><img src="/wp-content/uploads/2013/06/27-offices-mc.jpg"></a>');

	$('.map1').append('<a href="#close-map1" id="close-map1" class="button-2">Close &uarr;</a>');

	$('a#open-map1').click(function() {

		$('.map1').slideDown(1000);
                $('html,body').animate({scrollTop: $(this).offset().top},500);

		return false;

	});

	$('a#close-map1').click(function() {

		$('.map1').slideUp(1000);

		return false;

	});


//INTERN (GRAD) FORM 

	$(".gradform, .internform").hide();
	$(".gradbtn").click(function(){
  		if ($(".internform").is(":visible")){
  			$(".internform").hide(1000);
  			$(".gradform").toggle(1000);
  		}
  		else{
    		$(".gradform").toggle(1000);
    	}
  	});
  	$(".internbtn").click(function(){
  		if ($(".gradform").is(":visible")){
  			$(".gradform").hide(1000);
  			$(".internform").toggle(1000);
  		}
  		else{
    		$(".internform").toggle(1000);
    	}
  	}); 



    
    
}); //END DOC READY

jQuery(window).load(function() {


// DEEP LINKING FOR FEATURED #TAG

 
    var option = {
    	'type'			:	'inline',
		'width'			:	'100%',
		'height'		:	'100%',
		'overflow'		:	'hidden',
		'autoSize'		:	false,
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	true,
		'padding'		: 	0,
		'beforeShow' 	: 	function() {
        	jQuery('.fancybox-overlay').css(
        	{
        	
        	'background-image'	:	'none',
        	'background-color'	:	'#FFF'
        	});
        	jQuery("body").css({'overflow-y':'hidden', 'height':'200px'});
    	},
        'afterLoad'		: 	function(links) {
            var title = links.element.attr('id');
            location.hash = title;
        },
        'afterClose'	: 	function() {
            location.hash = '';
            jQuery("body").css({'overflow-y':'visible', 'height':'100%'});
        },
        
    },
    hash = location.hash.substr(1),
    deeplinked = jQuery("#hspot_press");
    if(hash.length > 0){
        //id
        var i = null;
        deeplinked.each(function(index) {
            var o = jQuery(this).attr('id');
            if(jQuery(this).attr('id') == hash){
                i = index;
                return;
            }
        });
        if(i != null){
            option.index = i;
            jQuery.fancybox.open(deeplinked,option);
        }
    }
     
    deeplinked.fancybox(option); 
	

});


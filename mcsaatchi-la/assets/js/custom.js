/*!
 * Custom JS fr M&C SAATCHI SHARE
 *
 * Sergio O'Farrill 
 */

var playvid = function(slider) {
var vid = slider.$currentPage.find('video');
if (vid.length) {
// autoplay
vid[0].play();
}
};
	  
// <!--PAGE TRANSITIONS-->

// <!--Smooth Scrolling-->

$(function() {
$('a[href*=#]:not([href=#])').click(function() {
if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
    || location.hostname == this.hostname) {

  var target = $(this.hash);
  target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
  if (target.length) {
    $('html,body').animate({
      scrollTop: target.offset().top
    }, 1000);
    return false;
  }
}
});
});


// <!-- AnythingSlider -->


		// DOM Ready
		$(function(){
		
		
		$('#vidSlider').anythingSlider({
    // If true, the entire slider will expand to fit the parent element
    expand: true,
    theme: "minimalist-round",
    resizeContents: true,
    autoPlay: true,
    delay: "7000",
    easing: "swing",
    pauseOnHover: true,
    stopAtEnd: true,
    resumeOnVideoEnd: true,
    // Autoplay video in initial panel, if one exists
		onInitialized: function(e, slider) {
		playvid(slider);
		},
		
		// pause video when out of view
		onSlideInit: function(e, slider) {
		var vid = slider.$lastPage.find('video');
		if (vid.length && typeof(vid[0].pause) !== 'undefined') {
		vid[0].pause();
		}
		},
		
		// play video
		onSlideComplete: function(slider) {
		playvid(slider);
		},
		
		// pause slideshow if video is playing
		isVideoPlaying: function(slider) {
		var vid = slider.$currentPage.find('video');
		return (vid.length && typeof(vid[0].pause) !== 'undefined' && !vid[0].paused && !vid[0].ended);
		}
		// 
 
   })
    
	});
	

// <script type="text/javascript">
// $(window).load(function() {
// $('.bxSlider').bxSlider({
// 	randomStart:false,
	// preloadImages:'all',
	// auto: true,
  // mode: 'fade',
  // captions: true,
  // pause: 7000,
  // speed: 2000,
  // autoHover: true,
  // video: true,
  // useCSS: false,
 
//   onSliderLoad: function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject){
    //Check if there's a video in the slide
 //    $('#work>ul>li').eq(0).css("font-size","50%")
    //   },
 //  onSlideBefore: function (currentSlideNumber, totalSlideQty, currentSlideHtmlObject) {
	// 		console.log(currentSlideHtmlObject);
// 			$('.workSlider').removeClass('hasVideo');
// 			$('#work>ul>li').eq(currentSlideHtmlObject - 1).addClass('workSlider active')
	// 	},
   
// 	});
// 	});
//</script>



// <!--SCROLL TO TOP-->

    $(document).ready(function() {
      // Show or hide the sticky footer button
      $(window).scroll(function() {
        if ($(this).scrollTop() > 200) {
          $('.go-top').fadeIn(200);
        } else {
          $('.go-top').fadeOut(200);
        }
      });
      
      // Animate the scroll to top
      $('.go-top').click(function(event) {
        event.preventDefault();
        
        $('html, body').animate({scrollTop: 0}, 800);
      })
    });

  



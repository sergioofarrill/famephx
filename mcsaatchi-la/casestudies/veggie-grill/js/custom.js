$(document).ready(function () {

    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    });

    $('.scrollup').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 1900);
        return false;
    });

// Video Stuff
    //return a DOM object
    var videoOne = $('#videoOne')[0];
    var videoTwo = $('#videoTwo')[0];
    //return a jQuery object
    var videoOne = $('#videoOne');
    var videoTwo = $('#videoTwo');

    videoOne.click(function(){
        if (this.paused) {
            this.play();
            return false;
        }
        return true;
    });

    //Play/Pause default btn clicked
    videoOne.on('play', function () {
        $('.btnPlayOne.icon').addClass('hidden');
    });
    videoOne.on('pause', function () {
        $('.btnPlayOne').removeClass('hidden');
    });

    //Play/Pause control clicked
    $('.btnPlayOne').on('click', function() {
        if(videoOne[0].paused) {
            videoOne[0].play();
            $('.btnPlayOne.icon').addClass('hidden');
        }
        
        else {
            videoOne[0].pause();
             $('.btnPlayOne').removeClass('hidden');
        }
        return false;

    });
    $(videoOne).on('ended',function(){
      $('.btnPlayOne').removeClass('hidden');
    });

    $('.btnPlayTwo').on('click', function() {
        if(videoTwo[0].paused) {
            videoTwo[0].play();
            $('.btnPlayTwo.icon').addClass('hidden');
        }
        else {
            videoTwo[0].pause();
            $('.btnPlayTwo').removeClass('hidden');
        }
        return false;
    });
    $(videoTwo).on('ended',function(){
      $('.btnPlayTwo').removeClass('hidden');
    });

});

  $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox();
  }); 

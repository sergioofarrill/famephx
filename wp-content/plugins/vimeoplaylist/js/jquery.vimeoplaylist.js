var Froogaloop=function(){function e(a){return new e.fn.init(a)}function h(a,c,b){if(!b.contentWindow.postMessage)return!1;var f=b.getAttribute("src").split("?")[0],a=JSON.stringify({method:a,value:c});"//"===f.substr(0,2)&&(f=window.location.protocol+f);b.contentWindow.postMessage(a,f)}function j(a){var c,b;try{c=JSON.parse(a.data),b=c.event||c.method}catch(f){}"ready"==b&&!i&&(i=!0);if(a.origin!=k)return!1;var a=c.value,e=c.data,g=""===g?null:c.player_id;c=g?d[g][b]:d[b];b=[];if(!c)return!1;void 0!==
a&&b.push(a);e&&b.push(e);g&&b.push(g);return 0<b.length?c.apply(null,b):c.call()}function l(a,c,b){b?(d[b]||(d[b]={}),d[b][a]=c):d[a]=c}var d={},i=!1,k="";e.fn=e.prototype={element:null,init:function(a){"string"===typeof a&&(a=document.getElementById(a));this.element=a;a=this.element.getAttribute("src");"//"===a.substr(0,2)&&(a=window.location.protocol+a);for(var a=a.split("/"),c="",b=0,f=a.length;b<f;b++){if(3>b)c+=a[b];else break;2>b&&(c+="/")}k=c;return this},api:function(a,c){if(!this.element||
!a)return!1;var b=this.element,f=""!==b.id?b.id:null,d=!c||!c.constructor||!c.call||!c.apply?c:null,e=c&&c.constructor&&c.call&&c.apply?c:null;e&&l(a,e,f);h(a,d,b);return this},addEvent:function(a,c){if(!this.element)return!1;var b=this.element,d=""!==b.id?b.id:null;l(a,c,d);"ready"!=a?h("addEventListener",a,b):"ready"==a&&i&&c.call(null,d);return this},removeEvent:function(a){if(!this.element)return!1;var c=this.element,b;a:{if((b=""!==c.id?c.id:null)&&d[b]){if(!d[b][a]){b=!1;break a}d[b][a]=null}else{if(!d[a]){b=
!1;break a}d[a]=null}b=!0}"ready"!=a&&b&&h("removeEventListener",a,c)}};e.fn.init.prototype=e.fn;window.addEventListener?window.addEventListener("message",j,!1):window.attachEvent("onmessage",j);return window.Froogaloop=window.$f=e}();
//-------------------------------------------------
//		Vimeo video jquery plugin with Froogaloop
//		Created by info@cfconsultancy.nl
//
//		v3.0
//-------------------------------------------------
jQuery.fn.viplaylist = function (options) {
    var options = jQuery.extend({
        holderId: 'vivideo',
        playerHeight: '390',
        playerWidth: '640',
        autoPlay: true,
        playOnLoad: false,
        playfirst: 0,
        sliding: true,
        listsliding: true,
        delay: 1500,
        social: true,
		slideshow: false,
        color: '00adef',
        portrait: true,
        title: true,
        byline: true,
        loop: false
    }, options);

    var selector = jQuery(this),
          autoPlay = '',
          color = '',
          slideshow = '',
          portrait = '&portrait=0',
          title = '&title=0',
          byline = '&byline=0',
          loop = '&loop=0';

    if (options.portrait) portrait = '&portrait=1';
    if (options.title) title = '&title=1';
    if (options.byline) byline = '&byline=1';
    if (options.loop) loop = '&loop=1';
    if (options.color) color = '&color=' + options.color + '';

	if (options.slideshow) loop = '&loop=0';

    var holder = jQuery('#' + options.holderId + '');
	var playerHeightcss = Math.ceil(options.playerWidth / 16*9);
	holder.css({'height' : '' + (playerHeightcss+5) + '' });

    function play(id) {
        if (options.autoPlay && options.playOnLoad) autoPlay = "&autoplay=1";
        options.playOnLoad = true;

        var html = '';
        if (id == false) {
        	return html;
        }
        else {

		html += '<iframe id="' + options.holderId + 'iframe" style="visibility:hidden;" onload="this.style.visibility=\'visible\';" class="vimeo-player-iframe" src="http://player.vimeo.com/video/' + id + '?' + autoPlay + color + portrait + title + byline + loop + '&api=1&player_id=' + options.holderId + 'iframe" width="' + options.playerWidth + '" height="' + playerHeightcss + '" frameborder="0" allowtransparency="true" webkitAllowFullScreen mozallowfullscreen allowFullScreen>';
		html += '</iframe>';
        return html;
        }
    };

    function addIframeHandles(){
    	if(options.slideshow == false){
        	return;
        }

	    var iframe = jQuery('#' + options.holderId + ' iframe')[0],
	    player = $f(iframe);

	    // When the player is ready, add listeners for pause, finish, and playProgress
	    player.addEvent('ready', function() {

	        player.addEvent('pause', onPause);
	        player.addEvent('finish', onFinish);
	        player.addEvent('playProgress', onPlayProgress);
	    });
    }

	function getVimeoId( url ) {
	  // look for a string with 'vimeo', then whatever, then a
	  // forward slash and a group of digits.
	  var match = /vimeo.*\/(\d+)/i.exec( url );

	  // if the match isn't null (i.e. it matched)
	  if ( match ) {
	    // the grouped/matched digits from the regex
	    return match[1];
	  }
	};

    var itemindex = 0;
    var scrolls = holder.parents('#vimeo_holder').find('ul:first').addClass('a' + options.holderId + '');
    var up = holder.parents('#vimeo_holder').find('.you_up').addClass('i' + options.holderId + '');
    var down = holder.parents('#vimeo_holder').find('.you_down').addClass('i' + options.holderId + '');

    //scrolls.slideUp(0);
    //down.show();

    var firstVid = jQuery(selector).filter(function (index) {
	return index == options.playfirst
    	}).addClass('currentvideo').attr('href');

    holder.html(play(getVimeoId(firstVid)));
	addIframeHandles();

    function socialicons () {
        holder.hover(function(){
            jQuery('.yfacebook, .ytwitter').fadeIn('slow');
        },
        function(){
            jQuery('.yfacebook , .ytwitter').fadeOut();
        });
    }
    //remove single and double quotes
	function delquote(str){
		return (str=str.replace(/["']{1}/gi,""));
	}

    var firstmovie = selector.filter('.currentvideo');
    var titlefirsttext = firstmovie.siblings('p').html();
    var vimeothumbs = firstmovie.children('img').attr('src').replace('_100.jpg', '_640.jpg');
    if (options.social) {
        holder.prepend('<div class="yfacebook" title="+ facebook" onclick="window.open(\'http://www.facebook.com/sharer.php?s=100&amp;p[title]=' + delquote(encodeURIComponent(titlefirsttext)) + '&amp;p[summary]=' + delquote(encodeURIComponent(firstmovie.text())) + '&amp;p[url]=' + encodeURIComponent(document.location) + '&amp;p[images][0]=' + encodeURIComponent(vimeothumbs) + '\', \'ysharer\', \'toolbar=0,status=0,width=548,height=325\');"></div><div class="ytwitter" title="+ twitter" onclick="window.open(\'https://twitter.com/share?url=' + encodeURIComponent(document.location) + '&amp;text=' + delquote(encodeURIComponent(firstmovie.text().substring(0, 100))) + '\', \'ysharert\', \'toolbar=0,status=0,width=548,height=325\');"></div>');
        socialicons();
    }

    selector.click(function () {

        if (options.sliding) {
            setTimeout(function(){
        		scrolls.slideUp(1500,'swing');
        	down.show();
        	},options.delay);
        }

        //up.hide();

        holder.html(play(getVimeoId(jQuery(this).attr('href'))));
		addIframeHandles();
        selector.filter('.currentvideo').removeClass('currentvideo');
        jQuery(this).addClass('currentvideo');

        var titletext = selector.filter('.currentvideo').siblings('p').html();
        var vimeothumbs = selector.filter('.currentvideo').children('img').attr('src').replace('_100.jpg', '_640.jpg');

        if (options.social) {
        	holder.prepend('<div class="yfacebook" title="+ facebook" onclick="window.open(\'http://www.facebook.com/sharer.php?s=100&amp;p[title]=' + delquote(encodeURIComponent(titletext)) + '&amp;p[summary]=' + delquote(encodeURIComponent(jQuery(this).text())) + '&amp;p[url]=' + encodeURIComponent(document.location) + '&amp;p[images][0]=' + encodeURIComponent(vimeothumbs) + '\', \'ysharer\', \'toolbar=0,status=0,width=548,height=325\');"></div><div class="ytwitter" title="+ twitter" onclick="window.open(\'https://twitter.com/share?url=' + encodeURIComponent(document.location) + '&amp;text=' + delquote(encodeURIComponent(jQuery(this).text().substring(0, 100))) + '\', \'ysharert\', \'toolbar=0,status=0,width=548,height=325\');"></div>');
        	socialicons();
	    }

        itemindex = jQuery(this).parent().index() * 77;

        if (!options.sliding && options.listsliding) {
            setTimeout(function(){
        		scrolls.animate({scrollTop: itemindex},'slow','swing');
        	},options.delay);
        }
        return false;
    });

	if (options.sliding) {
	    up.show();

	    down.bind('click', function() {

	    scrolls.slideDown('slow','swing', function() {
	            up.show();
	            down.hide();
                scrolls.animate({scrollTop: itemindex},'slow','swing');
	        });
	    });

	    up.click(function() {
	        scrolls.slideUp('slow','swing', function() {
	            up.hide();
	            down.show();
	        });
	    });
	}

    var iframe = jQuery('#' + options.holderId + ' iframe')[0],
    player = $f(iframe);

    function onPause(id) {
    }

    function onFinish(id) {
		var holder = jQuery('#' + options.holderId).parent();
		if(holder.find('.currentvideo').parent('li').next().size() == 1){
			var next = holder.find('.currentvideo').parent('li').next();
		}else{
			var next = holder.find('li:first');
		}
		var current = holder.find('.currentvideo');

		next.find(jQuery(selector)).addClass('currentvideo');
		current.removeClass('currentvideo');
		jQuery('#' + options.holderId).html(play(getVimeoId(next.find(jQuery(selector)).attr('href'))));
		addIframeHandles();

        itemindex = next.index() * 77;

        if (options.listsliding) {
            setTimeout(function(){
        		scrolls.animate({scrollTop: itemindex},'slow','swing');
        	},options.delay);
        }
    }

    function onPlayProgress(data, id) {
	}
};
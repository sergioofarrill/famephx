/*
 * Fancy Gallery v1.6.1
 *
 * Copyright 2011, Rafael Dery
 *
 * Only for sale at the envato marketplaces
 */
 
;(function($) {
	
	jQuery.fn.fancygallery = function(arg){
			
		//saving options
		var options = $.extend({}, $.fn.fancygallery.defaults, arg);
		options.thumbnailSelectionOptions = $.extend({}, $.fn.fancygallery.defaults.thumbnailSelectionOptions, options.thumbnailSelectionOptions);
		options.inlineGalleryOptions = $.extend({}, $.fn.fancygallery.defaults.inlineGalleryOptions, options.inlineGalleryOptions);
		
		//global variables
		var albums, album, albumSelector, nav, $inlineGallery, totalImagePages = 0, currentPageIndex = -1, currentAlbumIndex = -1, $elem, hoverImageWidth, hoverImageHeight;
		
		function init(element) {
			
			$elem = $(element).addClass('fg-panel radykal-clearfix');
			
			albums = $elem.children('div').hide();
			
			if(!options.slideTitle && !options.showTitle) {
				options.titleHeight = 0;
			}
			
			if(options.navStyle == 'white' || options.navStyle == 'black') {
				options.navStyle = 'fg-nav-'+options.navStyle;
			}
			
			if(options.lightbox == 'inline') {
				var inlineMediaHeight = Number(options.inlineGalleryOptions.height)+12;
				$inlineGallery = $elem.append('<div class="fg-inline-gallery" style="width: '+options.inlineGalleryOptions.width+'px;"><p class="fg-inline-gallery-title"></p><div class="fg-inline-gallery-media" style="height: '+inlineMediaHeight+'px;"></div><p class="fg-inline-gallery-description"></p></div>').children('.fg-inline-gallery');
				
			}
			
			var listItemTotalWidth = 1 + options.thumbWidth + (options.borderThickness*2),
				originColumnOffset = options.columnOffset;
			if(options.columns > 0) {
				options.columnOffset =  ($elem.width() - (options.columns * listItemTotalWidth)) / (options.columns-1);
			}
			else {
				options.columns = Math.round(($elem.width() - options.columnOffset) / (listItemTotalWidth + options.columnOffset));
			}
			
			options.columnOffset = options.columnOffset < originColumnOffset ? originColumnOffset : options.columnOffset;			
			
			//create album selection
			if(options.albumSelection == 'dropdown') {
				
				if(options.dropdown && albums.length > 1) {
					albumSelector = $elem.append('<div class="fg-dropdown"><div class="fg-current-album fg-current-album-'+options.dropdownTheme+'"></div><ul class="fg-dropdown-list fg-dropdown-list-'+options.dropdownTheme+'"></ul></div>').children('.fg-dropdown');
				
					if(/\S/.test(options.allMediasSelector)) {
						if(options.allMediasSelector == options.selectAlbum) { 
							albumSelector.children('.fg-current-album').text(options.allMediasSelector); 
						}
						albumSelector.children('.fg-dropdown-list').append("<li>"+options.allMediasSelector+"</li>");
					}
					$.each($elem.children('div:hidden:not(.fg-inline-gallery)'), function(i, albumItem){
						if(options.selectAlbum == '') {
							if(i == 0) { albumSelector.children('.fg-current-album').text(albumItem.title); }
						}
						else {
							if(options.selectAlbum == albumItem.title) { albumSelector.children('.fg-current-album').text(albumItem.title); }
						}
						albumSelector.children('.fg-dropdown-list').append("<li>"+albumItem.title+"</li>");
					});
					
					//toggle dropdown
					albumSelector.on('click', '.fg-current-album', function() {
						albumSelector.children('.fg-dropdown-list').stop().slideToggle(200);
					});
					
					//load album by index
					albumSelector.on('click', 'li', function() {					
						albumSelector.children('.fg-dropdown-list').stop().slideUp(200);
						albumSelector.children('.fg-current-album').text($(this).text());
						loadAlbum(albumSelector.children('.fg-dropdown-list').children('li').index(this));
					});
					
				}
				
			}
			else if(options.albumSelection == 'menu') {
			
				albumSelector = $elem.append("<ul class='fg-albumSelecter radykal-clearfix'></ul>").children(".fg-albumSelecter");
				
				var selected = '';
				if(/\S/.test(options.allMediasSelector)) {
					if(options.allMediasSelector == options.selectAlbum) { selected = "selected"; }
					albumSelector.append("<li class='"+selected+"'><a href='#'>"+options.allMediasSelector+"</a></li>");
				}

				$.each($elem.children('div:hidden:not(.fg-inline-gallery)'), function(i, albumItem){
					selected = albumItem.title == options.selectAlbum ? "selected" : "";
					if(i == 0 && options.selectAlbum == '') {
						selected = "selected";
					}
					
					albumSelector.append("<li class='"+selected+"'><a href='#'>"+albumItem.title+"</a></li>");
				});
				
				albumSelector.children('li').children('a').click(function() {
					var $this = $(this);
					if($this.parent().hasClass('selected')) { return false; }
					albumSelector.children('li').removeClass('selected');
					$this.parent().addClass('selected');
					loadAlbum(albumSelector.children('li').index(albumSelector.children('.selected')));
					return false;
				});
			}
			else {
				
				albumSelector = $elem.append("<ul class='fg-thumbail-selection radykal-clearfix'></ul>").children(".fg-thumbail-selection");

				function appendThumbnailSelection(title, img, size) {
					if(options.thumbnailSelectionOptions.layout == 'default') {
						albumSelector.append('<li class="fg-album-thumbnail"><a href="#" style="width: '+options.thumbnailSelectionOptions.width+'px; height: '+options.thumbnailSelectionOptions.height+'px;"><img src="'+img+'" /></a><div style="background: '+options.backgroundColor+';"><div class="fg-album-thumbnail-title" style="color: '+options.titleColor+';">'+title+'</div><div class="fg-album-thumbnail-length">'+size+' '+options.mediaText+'</div></div></li>');
					}
					else {
						albumSelector.append('<li class="fg-album-polaroid"><a href="#"><img src="'+img+'" /><span>'+size+'</span></a><p>'+title+'</p></li>');
					}
					
				};
				
				if(/\S/.test(options.allMediasSelector)) {
					appendThumbnailSelection(options.allMediasSelector, albums.children('a:first').attr('href'), albums.children('a').length);
				}
				
				$.each($elem.children('div:hidden:not(.fg-inline-gallery)'), function(i, albumItem){
					var $albumItem = $(albumItem);
					appendThumbnailSelection($albumItem.attr('title'), $albumItem.data('thumbnail') ? $albumItem.data('thumbnail') : $albumItem.find('a:first').attr('href'), $albumItem.children('a').length);
				});				
				
				albumSelector.children('li').show().children('a').click(function() {
					
					if(options.showOnlyFirstThumbnail) {
						$elem.children('.fg-thumbHolder').hide();
						loadAlbum(albumSelector.children('li').index($(this).parent()));
						$elem.children('.fg-thumbHolder').children('li:first').children('a:first').click();
					}
					else {
						albumSelector.hide();
						if(nav) { nav.show(); }
						loadAlbum(albumSelector.children('li').index($(this).parent()));
					}
					
					return false;
				});
				
			}
									
			//add horizontal line under menu
			if(options.divider && options.albumSelection != 'thumbnails') {
				$elem.append("<hr class='fg-line' />");
			}
						
			//create holder for the images
			$elem.append("<ul class='fg-thumbHolder radykal-clearfix'></ul>");
			
			//add album description
			if(options.albumDescriptionPosition == 'top') {
				$elem.children('.fg-thumbHolder').before('<p class="fg-album-description"></p>');
			}
			else {
				$elem.children('.fg-thumbHolder').after('<p class="fg-album-description"></p>');
			}
			
			//create holder for the navigation
			nav = $("<div class='fg-navigation radykal-clearfix' style='text-align: "+options.navAlignment+"'></div>");
			options.navPosition == 'top' ? $elem.children('div:hidden').last().after(nav) : $elem.append(nav);
			
			//back button for thumbnail selection
			if(options.albumSelection == 'thumbnails') {
				nav.hide().append('<a href="#" class="fg-pagination fg-back-to-albums '+options.navStyle+'">'+options.navBackText+'</a>').children('.fg-back-to-albums').click(function() {
					if(nav) { nav.hide(); }
					$elem.find('.fg-thumbHolder').empty();
					$elem.children('.fg-thumbail-selection').fadeIn(400);
					if($inlineGallery) {
						$inlineGallery.slideUp(200).children('.fg-inline-gallery-media').empty();
					}
					
					return false;
				});
			}
			
			//create previous/next buttons
			if(options.imagesPerPage != 0 ) {
				
				if(options.navigation != 'dots') {
					
					nav.append('<a class="fg-pagination fg-pagination-prev '+options.navStyle+'" href="" title="Previous image stack">'+options.navPreviousText+'</a>').find('.fg-pagination-prev').click(function(evt){
						if(currentPageIndex == 0) { loadImages(totalImagePages-1); }
						else { loadImages(currentPageIndex-1); }
						return false;	
					});
					
					nav.append('<a class="fg-pagination fg-pagination-next '+options.navStyle+'" href="#" title="Next image stack">'+options.navNextText+'</a>').find('.fg-pagination-next').click(function(evt){
						if(currentPageIndex == totalImagePages-1) { loadImages(0); }
						else { loadImages(currentPageIndex+1); }
						return false;	
					});
					
				}
			}
			
			//first check if gallery has albums
			if(albums.length > 0) {		
				//trigger change event for album selecter
				if(options.albumSelection == 'dropdown') {
					if(options.selectAlbum == '' || options.allMediasSelector == options.selectAlbum) {
						loadAlbum(0);
					}
					else {
						albumSelector.find('li').each(function(i, album) {
							if(album.innerHTML == options.selectAlbum) {
								loadAlbum(i);
							}
						});
					}				
				}
				else if(options.albumSelection == 'menu') {
					loadAlbum(albumSelector.children('li').index(albumSelector.children('.selected')));
				}
				
			}
			
		};
		
		function loadAlbum(index){
			
			$elem.children('.fg-album-description').hide().html('');
			
			currentPageIndex = -1;
			//save current album index
			currentAlbumIndex = /\S/.test(options.allMediasSelector) ? index-1 : index;
			if(/\S/.test(options.allMediasSelector) && index == 0) {
				album = albums.children('a');
			}
			else {
				album = $(albums[currentAlbumIndex]).children('a');
				if(albumHtml = $(albums[currentAlbumIndex]).children('div:first').html()) {
					$elem.children('.fg-album-description').html(albumHtml).stop().fadeIn(500);
				}
				
			}
			
			totalImagePages = options.imagesPerPage == 0 ? 1 : Math.ceil(album.length / options.imagesPerPage);

			if(nav) {
				nav.children('.fg-pagination-number, .fg-navigation-dot').remove();
			}
			
			if(options.navigation == 'dots' || options.navigation == 'pagination') {
				
				if(totalImagePages > 1) {
				
					for(var i=0; i < totalImagePages; ++i) {
						if(options.navigation == 'dots') {
							nav.append('<a href="'+i+'" class="fg-navigation-dot '+options.navStyle+'"></a>');
						}
						else {
							nav.children('a:last').before('<a href="'+i+'" class="fg-pagination fg-pagination-number '+options.navStyle+'">'+(i+1)+'</a>');
						}
						
						if(i == 0) { selectPaginationNumber(0); }
					}
					
					nav.children('.fg-navigation-dot, .fg-pagination-number').click(function() {
						var $this = $(this);
						loadImages($this.attr('href'));
						return false;
					});
				}
				
			}
			
			//empty the thumb holder
			$elem.find('.fg-thumbHolder').empty();
			
			//check if album has media
			if(album.length == 0) {
				$elem.find('.fg-thumbHolder').append("<p>This album has no media files!</p>");
				return false;
			}
			
			//the album loop
			for(var i=0; i<album.length; ++i){
			
				var item = album.get(i);
				var image = item.href;
				var thumbnail = $(item).children('img:first').attr('src');
				var title = $(item).children('img:first').attr('title') ? $(item).children('img:first').attr('title') : '';
				var description = $(item).has('span').length ? $(item).children('span:first').html() : '';
				
				createThumbnail($elem.children('.fg-thumbHolder'), image, thumbnail, title, description);
				
			}
			
			$elem.children('.fg-thumbHolder').children('.fg-listItem:last').css('marginRight', 0);
			
			
			//use inline gallery
			if(options.lightbox == 'inline') {
			
				$elem.find("a.fg-image").click(function() {
					var media = this.href,
						$this = $(this),
						type = _getFileType(media);
					
					
					var mediaHtml;
					if(type == 'image') {
						mediaHtml = '<img style="height: '+options.inlineGalleryOptions.height+'px;" src="'+media+'" title="'+$this.children('.fg-thumb').attr('alt')+'" />';
					}
					else if(type == 'youtube') {
						var ytId = _getParam(media, 'v'),
							mediaHtml = '<iframe width="100%" height="'+options.inlineGalleryOptions.height+'" src="http://www.youtube.com/embed/'+ytId+'?'+options.inlineGalleryOptions.youtubeParameters+'" frameborder="0" allowfullscreen></iframe>';
							
					}
					else if(type == 'vimeo') {
						var vimeoId = media.match(/http:\/\/(www\.)?vimeo.com\/(\d+)($|\/)/),
							vimeoId = vimeoId[2],
							mediaHtml = '<iframe src="http://player.vimeo.com/video/'+vimeoId+'?'+options.inlineGalleryOptions.vimeoParameters+'" width="100%" height="'+options.inlineGalleryOptions.height+'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
							
					}
					else if(type == 'mp4') {
							mediaHtml = '<video id="fg-mp4-video" src="'+media+'" autoplay></video>';
														
							
					}
					else {
						window.open(media, '_blank');
						return false;
					}
					
					$inlineGallery.children('.fg-inline-gallery-title').text($this.children('.fg-thumb').attr('alt'));
					$inlineGallery.children('.fg-inline-gallery-description').html(this.title);
					$inlineGallery.children('.fg-inline-gallery-media').empty().append(mediaHtml);
					
					if(type == 'mp4') {
						$inlineGallery.children('.fg-inline-gallery-media').children('video').mediaelementplayer({
							videoWidth: '100%',
							videoHeight: '100%'
						});
						
						$inlineGallery.children('.fg-inline-gallery-media').children('.mejs-container').addClass('mejs-yellow');
					}
					
					$inlineGallery.children('.fg-inline-gallery-media').children().css({'background': options.backgroundColor, 'borderColor': options.borderColor}).fadeIn(500);
					
					
					if($inlineGallery.is(':hidden')) {
						$inlineGallery.slideDown(500);
					}
					return false;
				});
				
				if(options.inlineGalleryOptions.showFirstMedia) {
					$inlineGallery.css('display', 'block');
					$elem.children('.fg-thumbHolder').find('.fg-image:first').click();
				}
				
			}
			//use lightbox
			else {
			
				//call the lightbox
				if(options.lightbox == 'prettyphoto') {
				
					//adds a pin it button to the prettyphoto lightbox
					if(options.boxOptions.social_tools == undefined) {
						options.boxOptions.social_tools = '<div class="twitter"><a href="http://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div><div class="facebook"><iframe src="//www.facebook.com/plugins/like.php?locale=en_US&href={location_href}&amp;layout=button_count&amp;show_faces=true&amp;width=500&amp;action=like&amp;font&amp;colorscheme=light&amp;height=23" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:500px; height:23px;" allowTransparency="true"></iframe></div><div class="pinterest"><a href="" class="pin-it-button" count-layout="horizontal" target="_blank"><img border="0" src="http://assets.pinterest.com/images/PinExt.png" title="Pin It" /></a></div>';
					}
	
					options.boxOptions.changepicturecallback = function() {
						var img = $('#fullResImage').attr('src');
						var title = $('.pp_pic_holder .ppt').text();
						//update pin it button
						$('.pp_pic_holder .pin-it-button').attr('href', 'http://pinterest.com/pin/create/button/?url='+encodeURIComponent(document.URL)+'&media='+encodeURIComponent(img)+'&description='+encodeURIComponent(title)+'');
					};
					$elem.find("a.fg-image").prettyPhoto(options.boxOptions);
				}
				else if(options.lightbox == 'fancybox') {
				
					//add social buttons to fancybox
					if(options.boxOptions.beforeShow == undefined) {
						options.boxOptions.beforeShow = function () {
						
							var description = this.element.data('description');
			                // New line
			                if(this.title) {
			                	this.title = '<p class="fancybox-description-title">'+this.title+'</p>';
			                }
			                
			                if(description && description.length) {
				                this.title += description+'<br /><br />';
			                }
			                
			                var href = encodeURIComponent(this.element.attr('href'));
			                // Add tweet button
			                this.title += '<a href="https://twitter.com/share" class="twitter-share-button" data-count="none" data-url="' + href + '">Tweet</a>  ';
			                
			                // Add FaceBook like button
			                this.title += '<iframe src="//www.facebook.com/plugins/like.php?href=' + href+ '&amp;layout=button_count&amp;show_faces=true&amp;width=500&amp;action=like&amp;font&amp;colorscheme=light&amp;height=23" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:110px; height:23px;" allowTransparency="true"></iframe>';
			                
			                this.title += '<a href="http://pinterest.com/pin/create/button/?url='+encodeURIComponent(window.location.href)+'&media='+href+'" class="pin-it-button" count-layout="horizontal" target="_blank"><img border="0" src="http://assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>';
			            
				        };
					}
					
					if(options.boxOptions.afterShow == undefined) {
						options.boxOptions.afterShow = function() {
				            // Render tweet button
				            twttr.widgets.load();
				        };
					}
			        
			        if(options.boxOptions.helpers == undefined) {
				        options.boxOptions.helpers = {
				            title : {
				                type: 'inside'
				            }
				        };
			        }			        
			        
					$elem.find("a.fg-image").fancybox(options.boxOptions);
				}
				else {
					$elem.find("a.fg-image").attr('rel', '').click(function() {
						window.open(this.href, '_blank');
						return false;
					});
				}
				
			}
			
			
			if(options.showOnlyFirstThumbnail) {
				$elem.children('.fg-thumbHolder').children('.fg-listItem:first').show();
				if(nav) { nav.hide(); }
			}
			else {
				loadImages(0);
			}
			
		};
		
		function createThumbnail(wrapper, originImage, thumbnail, title, description) {
		
			var hoverImageDom = '';
			if(/\S/.test(options.hoverImage)) {
				hoverImageDom = '<img src="'+options.hoverImage+'" class="fg-hover-image" />';
			}

			wrapper.append('<li class="fg-listItem"><a href="'+originImage+'" data-description="'+description+'" title="'+(options.lightbox == 'fancybox' ? title : description)+'" rel="prettyphoto['+$elem.attr("id")+']" class="fg-image" style="border-color: '+options.borderColor+';"><img class="fg-thumb" src="'+thumbnail+'" alt="'+title+'" />'+hoverImageDom+'</a><span class="fg-title" style="border-color: '+options.borderColor+';"></span><img src="'+options.shadowImage+'" class="fg-shadow" width='+(options.thumbWidth+options.borderThickness*2)+' /></li>');
			
			
			//get last added list item
			var lastListItem = $elem.find('.fg-listItem:last').css({
				width: options.thumbWidth+options.borderThickness*2,
				height: options.thumbHeight+options.titleHeight+options.borderThickness*2,
				'marginBottom': options.rowOffset,
				'marginRight': options.columnOffset
			});
			
			var totalRowWidth = (options.thumbWidth + options.borderThickness*2 + options.columnOffset) * options.columns - options.columnOffset;
			if(wrapper.children('li').size() > 1 && (wrapper.children('li').size()-1) % options.columns == 0 &&  totalRowWidth <= $elem.width()) {
				lastListItem.css('clear', 'both').prev('li').css('marginRight', 0);
			}
			
			//add a second thumbnail which be will created with timthumb for hover effects
			if(options.secondThumbnail) {
				var thumbnailUrl = options.timthumbUrl+'?src='+thumbnail+options.timthumbParameters+'&q=100&h='+options.thumbHeight+'&w='+options.thumbWidth;
				if(thumbnail.indexOf('timthumb.php') != -1) {
					thumbnailUrl = thumbnail+options.timthumbParameters;
				}
				lastListItem.find('.fg-thumb').after('<img class="fg-second-thumb" src="'+thumbnailUrl+'" alt="'+title+'" title=" " style="top: '+options.borderThickness+'px; left: '+options.borderThickness+'px;" />');
			}
			
			//get width and height of the hover image
			if(/\S/.test(options.hoverImage) && hoverImageWidth == undefined) {
				lastListItem.find('.fg-hover-image').load(function() {
					hoverImageWidth = $(this).width();
					hoverImageHeight = $(this).height();
				});
			}
			
			if(options.shadowImage == '') {
				lastListItem.children('.fg-shadow').css( 'display', 'none' );
			}

		    if(options.showTitle && title.length) {
				lastListItem.children('.fg-title').text(title).css( 'height', options.titleHeight );
				lastListItem.children('.fg-shadow').css('top', options.thumbHeight + options.titleHeight + options.shadowOffset + options.borderThickness*2);		
			}
			else {
				lastListItem.children('.fg-shadow').css('top', options.thumbHeight + options.shadowOffset + options.borderThickness*2);
			}
								
			//fade in thumb container and add a mouse hover
			lastListItem.hide().hover(
				//mouse over function
				function(){
				
					var $this = $(this);
					
					//prevent title tooltip
					$this.data('title', $this.children('.fg-image').attr('title'));
					$this.children('.fg-image').attr('title', '');
					
					if(options.secondThumbnail) { 
						var title = $this.find('.fg-second-thumb').stop().fadeTo(400, 0).attr('alt');
					}
					else {
						var title = $this.find('.fg-thumb').stop().fadeTo(400, options.inverseHoverEffect ? options.thumbOpacity : 1).attr('alt');
					}
					
					if(/\S/.test(options.hoverImage) && hoverImageWidth) {
						
						var animationObject, startObject, currentThumbWidth = $this.find('.fg-thumb').width();
						switch(options.hoverImageEffect) {
						
							case 'fade':
								startObject = {display: 'block', opacity: 0, left: (currentThumbWidth * 0.5) - (hoverImageWidth * 0.5), top: (options.thumbHeight * 0.5) - (hoverImageHeight * 0.5)};
								animationObject = {opacity: 1};
							break;
							case 'l2r':
								startObject = {display: 'block', left: -hoverImageWidth, top: (options.thumbHeight * 0.5) - (hoverImageHeight * 0.5)};
								animationObject = {left: (currentThumbWidth * 0.5) - (hoverImageWidth * 0.5)};
							break;
							case 'r2l':
								startObject = {display: 'block', left: currentThumbWidth + hoverImageWidth, top: (options.thumbHeight * 0.5) - (hoverImageHeight * 0.5)};
								animationObject = {left: (currentThumbWidth * 0.5) - (hoverImageWidth * 0.5)};
							break;
							case 't2b':
								startObject = {display: 'block', left: (currentThumbWidth * 0.5) - (hoverImageWidth * 0.5), top: -hoverImageHeight};
								animationObject = {top: (options.thumbHeight * 0.5) - (hoverImageHeight * 0.5)};
							break;
							case 'b2t':
								startObject = {display: 'block', left: (currentThumbWidth * 0.5) - (hoverImageWidth * 0.5), top: options.thumbHeight + hoverImageHeight};
								animationObject = {top: (options.thumbHeight * 0.5) - (hoverImageHeight * 0.5)};
							break;
							
						}
						
						$this.find('.fg-hover-image').css(startObject).stop().animate(animationObject, 400);
					}
					
					if(title == ""|| !options.slideTitle || $this.find('.fg-title').height() > 0) {
						return false;
					}

					if(options.shadowImage != '') {
						$this.find('.fg-shadow').stop().animate({'top': options.thumbHeight + options.titleHeight + options.shadowOffset + options.borderThickness*2}, 200);
					}
					
					var titleSpan = $this.find('.fg-title').empty();				
					$this.find('.fg-title').stop().animate({'height': options.titleHeight}, 200, function(){
						if (getInternetExplorerVersion() > -1 && getInternetExplorerVersion() <= 8.0) {
							$this.find('.fg-title').text(title); 
						}
						else {
							//fade in each letter of the title
							var spanArray = [];
							for(var i = 0; i < title.length; ++i) {
								titleSpan.append("<span>"+title.charAt(i)+"</span>");
								spanArray.push(titleSpan.find('span:last').hide());
							}
							
							//fade direction
							if(options.textFadeDirection === 'reverse') {
								spanArray.reverse();
							}
							else if(options.textFadeDirection === 'random') {
								spanArray.shuffle();
							}
							
							for(i in spanArray) {
								if($(spanArray[i]).is('span')) {
									$(spanArray[i]).stop().fadeIn(50 * i);
								}
							}
						}			
					});
				},					
				//mouse out function
				function(){
					var $this = $(this);
					
					$this.children('.fg-image').attr('title', $this.data('title'));
					
					if(/\S/.test(options.hoverImage) && hoverImageWidth) {
						
						var animationObject;
						switch(options.hoverImageEffect) {
						
							case 'fade':
								animationObject = {opacity: 0};
							break;
							case 'l2r':
								animationObject = {left: options.thumbWidth + hoverImageWidth};
							break;
							case 'r2l':
								animationObject = {left: -hoverImageWidth};
							break;
							case 't2b':
								animationObject = {top: options.thumbHeight + hoverImageHeight};
							break;
							case 'b2t':
								animationObject = {top: -hoverImageHeight};
							break;
							
						}
						
						$this.find('.fg-hover-image').stop().animate(animationObject, 200);
					}
					
					if(options.secondThumbnail) { 
						var title = $this.find('.fg-second-thumb').stop().fadeTo(200, 1).attr('alt');
					}
					else {
						var title = $this.find('.fg-thumb').stop().fadeTo(200, options.inverseHoverEffect ? 1 : options.thumbOpacity).attr('alt');
					}
					
					if(title == "" || !options.slideTitle) {
						return false;
					}
					$this.find('.fg-title').empty().stop().animate({'height': 0}, 200);	
					if(options.shadowImage != '') {
					    $this.find('.fg-shadow').stop().animate({'top': options.thumbHeight + options.shadowOffset + options.borderThickness*2}, 200);
					}
				}
			);
			
			//scale thumbnail
			var lastImg = lastListItem.find('.fg-thumb');
			$(lastImg).load(function() {
			  var loadedImg = $(this);
			  if(options.scaleMode == 'prop') {
				  var ratio = options.thumbHeight / options.thumbWidth;
				  if (loadedImg.height() / loadedImg.width() > ratio){
					if (loadedImg.height() > options.thumbHeight){
					  loadedImg.css('width', Math.round(loadedImg.width()*(options.thumbHeight / loadedImg.height())) );
					  loadedImg.css('height', options.thumbHeight);
					}
				  } else {
					if (loadedImg.width() > options.thumbHeight){
					  loadedImg.css('height', Math.round(loadedImg.height()*(options.thumbWidth / loadedImg.width())) );
					  loadedImg.css('width', options.thumbWidth);
					}
				  }
			  }
			  else if(options.scaleMode == 'stretch') {
				  loadedImg.css('width', options.thumbWidth);
				  loadedImg.css('height', options.thumbHeight);
			  }
			  else {
				  loadedImg.css('width', options.thumbWidth);
				  loadedImg.wrap("<div style='height:"+options.thumbHeight+"px; overflow:hidden; display:block;'></div>");
				  loadedImg.parent().next('.fg-second-thumb').wrap("<div style='height:"+options.thumbHeight+"px; overflow:hidden; display:block;'></div>");
			  }
			  
			  //set thumbnail opacity
			  loadedImg.fadeTo(0, options.inverseHoverEffect ? 1 : options.thumbOpacity );
			  loadedImg.next('.fg-second-thumb').show().width(loadedImg.width()).height(loadedImg.height());
			  
			});
			
			//set background
			lastListItem.find('.fg-image').css({
				'background-color': options.backgroundColor,
				'padding': options.borderThickness,
				width: options.thumbWidth,
				height: options.thumbHeight
			});
			
			//set background
			lastListItem.find('.fg-title').css({
				width: options.thumbWidth,
				'background-color': options.backgroundColor,
				'color': options.titleColor,
				'paddingLeft': options.borderThickness,
				'paddingRight': options.borderThickness,
				top: 1+options.thumbHeight+options.borderThickness*2
			});
			
			//set descirption again
			lastListItem.children('.fg-image').click(function() {
				var $this = $(this);
				$this.attr('title', $this.parent().data('title'));
			});
			
		}
		
		function loadImages(pageIndex){
			
			pageIndex = Number(pageIndex);
			if(currentPageIndex == pageIndex) { return false; }
			currentPageIndex = pageIndex;
			
			$elem.children('.fg-thumbHolder').children('li:visible').hide();
			
			var ipp = options.imagesPerPage == 0 ? album.length : options.imagesPerPage;
			for(var i=0; i<ipp; ++i) {
			
				var thumbnail = $elem.children('.fg-thumbHolder').children('li').eq((options.imagesPerPage * pageIndex) + i);
				var transitionObject;
				switch(options.thumbnailTransition) {
					case 'none':
						thumbnail.show();
					break;
					case 'fade':
						thumbnail.fadeIn(400+(i * 50));
					break;
				}			
				
			}
			
			if(nav != undefined) {
				if(totalImagePages > 1) {
					nav.children('.fg-pagination-prev, .fg-pagination-next').css('visibility', 'visible');
				}
				else {
					nav.children('.fg-pagination-prev, .fg-pagination-next').css('visibility', 'hidden');
				}
			}
			
			selectPaginationNumber(pageIndex);
						
		};
		
		//select pagination number by the index
		function selectPaginationNumber(index) {
			
			if(nav != undefined) {
				nav.children('a').removeClass(options.navStyle+'-selected');
				
				if(options.navigation == 'pagination') {
					nav.children('.fg-pagination-number').eq(index).addClass(options.navStyle+'-selected');
				}
				else if(options.navigation == 'dots') {
					nav.children('.fg-navigation-dot').eq(index).addClass(options.navStyle+'-selected');
				}
			}
			
		};
		
		function getInternetExplorerVersion() {
		  var rv = -1; // Return value assumes failure.
		  if (navigator.appName == 'Microsoft Internet Explorer')
		  {
		    var ua = navigator.userAgent;
		    var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
		    if (re.exec(ua) != null)
		      rv = parseFloat( RegExp.$1 );
		  }
		  return rv;
		};
		
		//returns the file type
		function _getFileType(media){
		
			if (media.match(/youtube\.com\/watch/i) || media.match(/youtu\.be/i)) {
				return 'youtube';
			}else if (media.match(/vimeo\.com/i)) {
				return 'vimeo';
			}else if(media.match(/\b.mp4\b/i)){ 
				return 'mp4';
			}else if(media.match(/\.(gif|jpg|jpeg|png)$/i)){
				return 'image';
			};
			
		};
		
		//returns the value of a parameter in the url
		function _getParam(url,key){
		
			key = key.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
			var regexS = "[\\?&]"+key+"=([^&#]*)";
			var regex = new RegExp( regexS );
			var results = regex.exec( url );
			return ( results == null ) ? "" : results[1];
			
		};
		
		return this.each(function() {init(this)});
	};
	
	
	
	//array shuffle
	function arrayShuffle(){
	  var tmp, rand;
	  for(var i =0; i < this.length; i++){
		rand = Math.floor(Math.random() * this.length);
		tmp = this[i]; 
		this[i] = this[rand]; 
		this[rand] = tmp;
	  }
	};
	Array.prototype.shuffle = arrayShuffle;
	
	$.fn.fancygallery.defaults = {
		thumbWidth: 140, //width of the thumbnail
		thumbHeight: 79, //height of the thumbnail
		backgroundColor: '#F5F5F5', //the color of background for every thumbnail
		titleColor: '#383634', //the color of the title
		borderThickness: 3, //the thickness of the border
		shadowOffset: 0, //the offset of the shadow (only for the standard view)
		thumbOpacity: 0.6, //the opacity of every thumbnail instead for the second thumbnail
		titleHeight: 20, //height of the title
		rowOffset: 25, //the offset of the row
		columnOffset: 30, //the offset of the column
		imagesPerPage: 10, //number of thumbnails per page, if 0 all thumbnails of an album will be loaded on the first page
		textFadeDirection: 'normal', //normal, reverse, random
		scaleMode: 'stretch', //prop, stretch, crop
		shadowImage: 'images/fancygallery/shadow.png', //shaodw image url
		hoverImage: '', //image url of the hover icon
		hoverImageEffect: 'fade', // the hover image effect - fade, l2r, r2l, t2b or b2t
		navPosition: 'bottom', //the position of the arrows
		selectAlbum: '', //load an album by its title
		dropdown: true, //hide/show dropdown
		divider: true, //hide/show divider (between controls and thumbnails)
		showTitle: false, //show/hide title
		slideTitle: true, //enable title slide
		inverseHoverEffect: false, //inverse the hover effect, so all images are clear by default and when you move your mouse over one, it will get an opacity 
		boxOptions: {}, //options for prettyphoto(http://www.no-margin-for-errors.com/projects/prettyPhoto-jquery-lightbox-clone/)
		secondThumbnail: false, //enable a second thumbail, which can be manipulated with timthumb
		timthumbUrl: 'php/timthumb.php', //the timthumb url
		timthumbParameters: '&zc=0&f=2', //the timthumb parameters for the second thumbnail
		allMediasSelector: '', //empty or custom label for showing all medias of an album
		albumSelection: 'dropdown', //menu, thumbnails or dropdown
		navigation: 'arrows', //dots, pagination, arrows
		navStyle: 'white', //white,black or a custom CSS class
		navAlignment: 'left', //the alignment of the navigation - left, center, right
		navPreviousText: '<', //text for the previous button
		navNextText: '>', //text for the next button
		navBackText: '&crarr;', //text for the back to album overview button
		thumbnailTransition: 'fade', //transition for the thumbnails - none, fade
		lightbox: 'prettyphoto', //choice between prettyphoto, fancybox, inline or none
		columns: 0, //1.5.1 - the number of columns
		mediaText: 'Media', //1.5.2 - the text for the media, only when using thumbnails as album selection
		showOnlyFirstThumbnail: false, //1.5.2 - show only the first thumbnail of an album
		dropdownTheme: 'white', //1.5.2 - the color theme for the dropdown
		borderColor: '#cccccc', //1.6 - the color for the border
		inlineGalleryOptions: {width: '100%', height: 500, youtubeParameters: '&showinfo=1&autoplay=1', vimeoParameters: 'autoplay=1', showFirstMedia: false},//1.6 - The options for the inline gallery
		thumbnailSelectionOptions : {layout: 'default', width: 250, height: 150}, // options for the thumbnail selection
		albumDescriptionPosition: 'top' //1.6 - the position of the album description - 'top' or 'bottom'
	};
	
})(jQuery);

//load twitter widget
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");

//load pinterest widget
(function(d){
  var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
  p.type = 'text/javascript';
  p.async = true;
  p.src = '//assets.pinterest.com/js/pinit.js';
  f.parentNode.insertBefore(p, f);
}(document));
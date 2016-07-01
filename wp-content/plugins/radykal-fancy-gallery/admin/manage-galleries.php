<div class="wrap <?php if( !current_user_can('manage_options') && FancyGallery::DEMO ){ echo " fg-disable-links"; } ?>">

  <div class="icon32" id="icon-upload"><br/></div>
  <h2><?php _e('Manage galleries', 'radykal'); ?></h2>
  
  <div id="fg-content" class="clearfix">
  
	  <div id="accordion-wrapper">
	  
		<h3><?php _e('Galleries', 'radykal'); ?></h3>
		
		<input type="text" name="gallery_title" class="widefat" id="gallery-title" />
		<a href="#" id="fg-add-gallery" class="fg-button fg-primary-button"><?php _e('Add Gallery', 'radykal'); ?></a>
		
		<ul id="galleries-accordion">
		<?php 
		$galleries = $this->wpdb->get_results("SELECT * FROM {$this->gallery_table_name} ORDER BY title");
		foreach($galleries as $gallery) {
			
			echo $this->get_gallery_list_item($gallery->ID, $gallery->title);
			
			 $album_results = $this->wpdb->get_results("SELECT * FROM {$this->album_table_name} WHERE gallery_id='{$gallery->ID}' ORDER BY sort ASC");
			 foreach($album_results as $album_result) {
				 echo $this->get_album_list_item($album_result->ID, $album_result->title, $album_result->description);
			 }
			
			echo "</ul></li>";
		}
		?>
		</ul>
		
		<label>Shortcode:</label>
		<input type="text" id="shortcode-output" value="" class="widefat" readonly="readyonly" />
		<span class="description"><?php _e('Paste the shortcode anywhere in your page or post.', 'radykal'); ?></span>
		<br /><br /><br /><br />
		<a href="http://radykal.de/codecanyon/wordpress/fancy-gallery/documentation/" target="_blank"><?php _e('Get instructions and hints in the documentation!', 'radykal'); ?></a>
		
	  </div>
	  
	  <div id="fg-right-col">
	  	<div id="media-buttons">
	  	
	  		<div style="float: left;">
	  			<div id="image-upload-form">
		  			<form>
		  				<a href="#" title="" id="upload-images-button" class="upload-button"><?php _e('Upload Images', 'radykal'); ?><span title='<?php _e('Multiple image selection is only supported in following browsers: <strong>Firefox 3.6+, Safari 5+, Google Chrome and Opera 11+.</strong><br /> Use CTRL or SHIFT for selecting multiple images. Maximum upload size for every image is 1MB.', 'radykal'); ?>' class="fg-tooltip"></span></a>
				    	<input type="file" name="files[]" multiple>
				    </form>
	  			</div>
	  			
	  			<a href="#fg-upload-other-modal" title="" id="upload-media-button" class="upload-button" data-toggle="modal"><?php _e('Upload other media', 'radykal'); ?><span title='<?php _e('You can only upload one media after another. This could be a Video(Quicktime, Youtube, Vimeo or Flash), an external site and more. <strong>Check out the documentation to get an overview which media types are supported in the different lightboxes!</strong>', 'radykal'); ?>' class="fg-tooltip"></span></a>
	  			<div class="clear" style="margin-top: 40px;">
	  				<input type="checkbox" id="titles-from-filenames" />
	  				<label><strong><?php _e('Get titles from filenames', 'radykal'); ?></strong></label>
	  			</div>
	  			
	  		</div>
	  		
	  		<div style="float: right;">
	  			<a href="#" id="update-media" class="fg-button fg-primary-button"><?php _e('Save Changes', 'radykal'); ?></a>
		  		<a href="#" id="select-all" class="fg-button fg-secondary-button" title="<?php _e('Select all media', 'radykal'); ?>" ><?php _e('Select all', 'radykal'); ?></a>
			  	<a href="#" id="deselect-all" class="fg-button fg-secondary-button" title="<?php _e('Deselect all media', 'radykal'); ?>" ><?php _e('Deselect all', 'radykal'); ?></a>
			  	<a href="#" id="delete-files" class="fg-button fg-secondary-button" title="<?php _e('Delete selected media', 'radykal'); ?>"><?php _e('Delete', 'radykal'); ?></a>
	  		</div>
	  			  		
	  	</div>
	  	
	  	<div id="fg-notification"></div>
	  	
	  	<div id="fg-alert">
		  	<ul></ul>
		  	<a href="#">&times;</a>
	  	</div>
	  		  	
		<ol id="mediaList" class="clearfix"></ol>
		
	  </div>
	  
  </div>
     
</div>

<!-- Modal for upload other media -->
<div id="fg-upload-other-modal" class="modal hide fade">
	<div class="modal-header">
		<h3><?php _e('Upload other media', 'radykal'); ?></h3>
	</div>
	<div class="modal-body">
	<p>
		<h4><?php _e('Enter the URL of the media or choice one from the media library, e.g. a youtube link:', 'radykal'); ?></h4>
		<input type="text" id="fg-modal-media" class="fg-modal-input widefat" />
		<input type="submit" class="button fg-add-from-media-library" value="<?php _e('Add from media library', 'radykal'); ?>" />
	</p>
	<br />
	<p>
		<h4><?php _e('Enter the URL of the thumbnail or choice one from the media library:', 'radykal'); ?></h4>
		<div class="hide" id="fg-load-from-container">
			<label for="fg-load-from" data-text="<?php _e('Load thumbnail from ', 'radykal'); ?>"></label>
			<input type="checkbox" name="fg-load-from" />
		</div>
		<input type="text" id="fg-modal-thumbnail" class="fg-modal-input widefat"  />
		<input type="submit" class="button fg-add-from-media-library" value="<?php _e('Add from media library', 'radykal'); ?>" />
	</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="fg-button fg-secondary-button" data-dismiss="modal" aria-hidden="true"><?php _e('Cancel', 'radykal'); ?></a>
		<a href="#" class="fg-button fg-primary-button" id="fg-add-media"><?php _e('Add media', 'radykal'); ?></a>
	</div>
</div>

<!-- Modal for upload other media -->
<div id="fg-album-description-modal" class="modal hide fade">
	<div class="modal-header">
		<h3><?php _e('Write a description for the album', 'radykal'); ?></h3>
	</div>
	<div class="modal-body">
	<?php
	$args = array(
		'media_buttons' => false,
		'textarea_name' => 'fgAlbumDescription',
		'textarea_rows' => 5,
		'tinymce' => array( 
			'theme_advanced_buttons1' =>'bold,italic,underline,separator,strikethrough,separatorforecolor,backcolor,separator,fontsizeselect,separator,link,unlink,separator,undo,redo',
			'theme_advanced_buttons2' => ''
		)
	);
	wp_editor( '', 'fgAlbumDescription', $args );
	?>
	</div>
	<div class="modal-footer">
		<a href="#" class="fg-button fg-secondary-button" data-dismiss="modal" aria-hidden="true"><?php _e('Cancel', 'radykal'); ?></a>
		<a href="#" class="fg-button fg-primary-button" id="fg-save-album-description"><?php _e('Save description', 'radykal'); ?></a>
	</div>
</div>


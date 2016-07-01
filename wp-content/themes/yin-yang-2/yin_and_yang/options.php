<?php
	
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_theme_data(STYLESHEETPATH . '/style.css');
	$themename = $themename['Name'];
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
	
	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
		
	// Background Defaults
	$background_defaults = array('color' => '#fdfdfd', 'image' => '', 'repeat' => 'repeat', 'position' => 'top left','attachment' => 'scroll');
	
	$bg_patterns = array("subtle-dots.png" => "Subtle Dots", "crossed_stripes.png" => "Crossed Stripes",
						 "small-grid.png" => "Small Grid", "medium-grid.png" => "Medium Grid", "small-crosses.png" => "Small Crosses", "small-squares.png" => "Small Squares",  
						 "diagonal-lines.png" => "Small Crosslines", 
						 "crosslines.png" => "Medium Crosslines", "cubes.png" => "Cubes", "double_lined.png" => "Double Lined", "fancy_deboss.png" => "Fancy Deboss", 
						 "pinstripe.png" => "Pinstripe", "subtle_freckles.png" => "Subtle Freckles", "subtle_orange_emboss.png" => "Subtle Emboss", "none" => "None");	
	
	// Pull all the categories into an array
	$options_categories = array();  
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = __( 'Select a page:', 'onioneye' );
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
		
	// If using image radio buttons, define a directory path
	$imagepath = get_stylesheet_directory_uri() . '/images/admin/';
		
	$options = array();
	
	
	
	/*-----------------------------------------------------------------------------------*/
	/* General Settings */
	/*-----------------------------------------------------------------------------------*/
		
	$options[] = array( "name" => __("General Settings", 'onioneye'),
						"type" => "heading");
						
	$options[] = array( "name" => __("Custom Logo", 'onioneye'),
						"desc" => __("Upload a logo for your theme. If you leave this option blank, the title that you have defined under the Settings &raquo; General tab, in " . 
									 "your WordPress admin panel, will be displayed instead of the logo image.", 'onioneye'),
						"id" => "custom_logo",
						"type" => "upload");
	
	$options[] = array( "name" => __("Custom Favicon", 'onioneye'),
						"desc" => __("Upload a 16px x 16px, or a 32px x 32px PNG/GIF/ICO image that will represent your website's favicon. " . 
								 	 "A favicon is an icon that gets displayed in the address bar of every browser.", 'onioneye'),
						"id" => "custom_favicon",
						"type" => "upload");
	
	$options[] = array( "name" => __("Top Drop-Down Page", 'onioneye'),
			          	"desc" => __("Choose one of the existent pages, whose content will be displayed on the top of every page, and whose visibility a user will be able to toggle, by clicking on the tab, generated in the top-right corner of the site. " . 
			          	             "In case you don't want a drop-down page, just don't select any of the available pages.", 'onioneye'),
			          	"id" => "dropdown_page",
			          	"std" => "Select a Page:",
			          	"type" => "select",
			          	"options" => $options_pages);
	
	$options[] = array( "name" => __("Disable Widgetized Bottom Overlay?", 'onioneye'),
			          	"desc" => __("Check this box if you want to disable the overlay area in the bottom of every page.", 'onioneye'),
			          	"id" => "footer_widgets_disabled",
			          	"std" => "0",
			          	"type" => "checkbox");
	          
	$options[] = array( "name" => __("Bottom Overlay Column Layout", 'onioneye'),
			          	"desc" => __("Select the number of bottom overlay columns/widget areas. The overlay widget areas are named Bottom 1, Bottom 2, Bottom 3, and Bottom 4, " .
					  			   	 "accordingly, and are so aligned from left to right, with Bottom 1 being the leftmost widget area, and Bottom 4 the righmost widget area. " .
					  			   	 "If you choose two widget areas for example, Bottom 1 and Bottom 2 are going to be displayed, while Bottom 3 and Bottom 4 are going to be ignored.", 'onioneye'),
			          	"id" => "footer_columns",
			          	"std" => 4,
			          	"type" => "radio",
			          	"options" => array(1 => __("One", 'onioneye'), 2 => __("Two", 'onioneye'), 3 => __("Three", 'onioneye'), 4 => __("Four", 'onioneye'))); 
	
	
	/*-----------------------------------------------------------------------------------*/
	/* Homepage Settings */
	/*-----------------------------------------------------------------------------------*/
		
	$options[] = array( "name" => __("Homepage Settings", 'onioneye'),
						"type" => "heading");
						
	$options[] = array( "name" => __("Headline Introduction Text", 'onioneye'),
			          	"desc" => __("Put the custom headline text here, that will appear below the logo. " .
			          				 "Leave this field blank, if you don't want a custom introduction text. " .
			          				 'Note: you may use these HTML tags and attributes: a (href, title, class, id), br, em (class, id), strong (class, id), span (class, id), abbr (title), cite, code, strike.', 'onioneye'),
			          	"id" => "intro_text",
			          	"std" => "",
			          	"type" => "textarea"); 
	
	$options[] = array( "name" => __("Client Logos", 'onioneye'),
						"desc" => __("Upload an image of your client logos, if you want it displayed on the landing page, right below the portfolio section. The maximum recommended width for this image is 940 pixels, with any height.", 'onioneye'),
						"id" => "client_logos",
						"type" => "upload");					
						
						
	/*-----------------------------------------------------------------------------------*/
	/* Blog Settings */
	/*-----------------------------------------------------------------------------------*/
		
	$options[] = array( "name" => __("Blog Settings", 'onioneye'),
						"type" => "heading");
	
	$options[] = array( "name" => __("Display Full Blog Posts or Display Excerpt?", 'onioneye'),
	          			"desc" => __("This option controls whether the blog index page displays the full posts, making use of the WordPress more quicktag, to designate the &ldquo;cut-off&rdquo; " .
	          			   			 "point for the post to be excerpted, or displays the excerpt of the current post, which refers to the first 90 words of the post's content.", 'onioneye'),
	          			"id" => "post_type",
	          			"std" => "excerpt",
	          			"type" => "radio",
	          			"options" => array("full" => __("Full Post", 'onioneye'), "excerpt" => __("Excerpt Post", 'onioneye'))); 
						
	$options[] = array( "name" => __("Disable the Sidebar on the Blog Page?", 'onioneye'),
			          	"desc" => __("Check this box to disable the sidebar on the blog page.", 'onioneye'),
			          	"id" => "blog_page_sidebar_disabled",
			          	"std" => "0",
			          	"type" => "checkbox");
          
	$options[] = array( "name" => __("Disable the Sidebar on Individual Blog Posts?", 'onioneye'),
			          	"desc" => __("Check this box to disable the sidebar on individual blog posts.", 'onioneye'),
			          	"id" => "single_post_sidebar_disabled",
			          	"std" => "0",
			          	"type" => "checkbox");
					
					
															
	/*-----------------------------------------------------------------------------------*/
	/* Styling Settings */
	/*-----------------------------------------------------------------------------------*/
	
	$options[] = array( "name" => "Styling Options",
						"type" => "heading");
						
	$options[] = array( "name" => __("Background Pattern/Image", 'onioneye'),
			          	"desc" => __("Select your theme's alternative background pattern. If you want to define your own, in the option below, or use a plain color for the background, select &ldquo;None.&rdquo;", 'onioneye'),
			          	"id" => "alt_pattern",
			          	"std" => "none",
			          	"type" => "select",
			          	"options" => $bg_patterns);
						
	$options[] = array( "name" => __("Body Background Color and Background Image", 'onioneye'),
						"desc" => __("Change the background color and the background image.", 'onioneye'),
						"id" => "body_bg",
						"std" => $background_defaults, 
						"type" => "background");
						
	$options[] = array( "name" => "Main Layout",
						"desc" => "Choose the position of the sidebar and the main content.",
						"id" => "sidebar_alignment",
						"std" => "two-cols-right-fixed",
						"type" => "images",
						"options" => array(
							'two-cols-right-fixed' => $imagepath . '2cr.png',
							'two-cols-left-fixed' => $imagepath . '2cl.png')
						);
			
	
	
	/*-----------------------------------------------------------------------------------*/
	/* Sociables options */
	/*-----------------------------------------------------------------------------------*/	
	
	$options[] = array( "name" => __("Social Networking", 'onioneye'),
	          			"type" => "heading"); 
	          
	$options[] = array( "name" => __("Twitter URL", 'onioneye'),
			          	"desc" => __("Enter your Twitter URL here.", 'onioneye'),
			          	"id" => "twitter_url",
			          	"std" => "",
			          	"type" => "text"); 
	          
	$options[] = array( "name" => __("Facebook URL", 'onioneye'),
			          	"desc" => __("Enter your Facebook URL here.", 'onioneye'),
			          	"id" => "facebook_url",
			          	"std" => "",
			          	"type" => "text"); 
	          
	$options[] = array( "name" => __("Flickr URL", 'onioneye'),
			          	"desc" => __("Enter your Flickr URL here.", 'onioneye'),
			          	"id" => "flickr_url",
			          	"std" => "",
			          	"type" => "text"); 
						
	$options[] = array( "name" => __("Vimeo URL", 'onioneye'),
			          	"desc" => __("Enter your Vimeo URL here.", 'onioneye'),
			          	"id" => "vimeo_url",
			          	"std" => "",
			          	"type" => "text");
						
	$options[] = array( "name" => __("YouTube URL", 'onioneye'),
			          	"desc" => __("Enter your YouTube URL here.", 'onioneye'),
			          	"id" => "youtube_url",
			          	"std" => "",
			          	"type" => "text");
			          	
	$options[] = array( "name" => __("LinkedIn URL", 'onioneye'),
			          	"desc" => __("Enter your LinkedIn URL here.", 'onioneye'),
			          	"id" => "linkedin_url",
			          	"std" => "",
			          	"type" => "text");
			          	
	$options[] = array( "name" => __("Google+ URL", 'onioneye'),
			          	"desc" => __("Enter your Google+ URL here.", 'onioneye'),
			          	"id" => "googleplus_url",
			          	"std" => "",
			          	"type" => "text");
						
	$options[] = array( "name" => __("Dribbble URL", 'onioneye'),
			          	"desc" => __("Enter your Dribbble URL here.", 'onioneye'),
			          	"id" => "dribbble_url",
			          	"std" => "",
			          	"type" => "text"); 
						
	$options[] = array( "name" => __("Tumblr URL", 'onioneye'),
			          	"desc" => __("Enter your Tumblr URL here.", 'onioneye'),
			          	"id" => "tumblr_url",
			          	"std" => "",
			          	"type" => "text");
						
	$options[] = array( "name" => __("Skype URL", 'onioneye'),
			          	"desc" => __("Enter your Skype URL here.", 'onioneye'),
			          	"id" => "skype_url",
			          	"std" => "",
			          	"type" => "text");
						
	$options[] = array( "name" => __("Delicious URL", 'onioneye'),
			          	"desc" => __("Enter your Delicious URL here.", 'onioneye'),
			          	"id" => "delicious_url",
			          	"std" => "",
			          	"type" => "text"); 
						
	$options[] = array( "name" => __("Digg URL", 'onioneye'),
			          	"desc" => __("Enter your Digg URL here.", 'onioneye'),
			          	"id" => "digg_url",
			          	"std" => "",
			          	"type" => "text");
	          
	$options[] = array( "name" => __("Feedburner RSS URL", 'onioneye'),
			          	"desc" => __("Enter your Feedburner URL here.", 'onioneye'),
			          	"id" => "rss_url",
			          	"std" => "",
			          	"type" => "text"); 
	            
	
	            
	/*-----------------------------------------------------------------------------------*/
	/* Footer options */
	/*-----------------------------------------------------------------------------------*/	
	
	$options[] = array( "name" => __("Footer", 'onioneye'),
	          			"type" => "heading"); 
	          
	$options[] = array( "name" => __("Copyright Footer Text", 'onioneye'),
			          	"desc" => __("Whatever text you enter here will be displayed in your website's footer area. The primary purpose of this option is to display your website's Copyright text, but you can enter whatever text you like.", 'onioneye'),
			          	"id" => "copyright_text",
			          	"std" => "&copy; " . date("Y") . ' ' . get_bloginfo('name') . ". All rights reserved.",
			          	"type" => "textarea");
		
	return $options;
	
	
}
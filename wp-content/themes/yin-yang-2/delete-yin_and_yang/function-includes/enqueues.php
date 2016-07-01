<?php
/*-----------------------------------------------------------------------------------*/
/*	Admin Meta Boxes Scripts and Styles
/*-----------------------------------------------------------------------------------*/
 
function eq_meta_boxes_scripts() {
	
	global $pagenow, $typenow, $current_screen;
  	
  	if ( empty( $typenow ) && !empty( $_GET['post'] ) ) {
    	$post = get_post( $_GET['post'] );
    	$typenow = $post -> post_type;
  	}
  
    // Load scripts only on the edit and the add new pages of the portfolio and the slider custom post types
	if ( $current_screen -> post_type == 'portfolio' || $current_screen -> post_type == 'slider' ) {
		if ( $pagenow=='post-new.php' OR $pagenow=='post.php' ) {	
			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'thickbox' );
			wp_register_script( 'metabox-upload', get_template_directory_uri() . '/admin/js/upload-button.js', array ( 'jquery', 'media-upload', 'thickbox' ) );
		    wp_enqueue_script( 'metabox-upload' );
			wp_register_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.custom.js', false, '2.0.8' );
    		wp_enqueue_script( 'modernizr' );
		}
    } 
}

function eq_meta_boxes_styles() {
	
	global $pagenow, $typenow, $current_screen;
  	
  	if ( empty( $typenow ) && !empty( $_GET['post'] ) ) {	
    	$post = get_post( $_GET['post'] );
    	$typenow = $post -> post_type;
	}
  
    // Load style sheets only on the edit and the add new pages of the portfolio and the slider custom post types
	if( $current_screen -> post_type == 'portfolio' || $current_screen -> post_type == 'slider' ) {
		if ( $pagenow=='post-new.php' OR $pagenow=='post.php' ) {	
			wp_enqueue_style( 'thickbox' );
			wp_enqueue_style( 'metabox-upload', get_template_directory_uri() . '/admin/css/meta-boxes.css' );
		}
    } 
	
}

add_action( 'admin_print_scripts', 'eq_meta_boxes_scripts' );
add_action( 'admin_print_styles', 'eq_meta_boxes_styles' );



/*-----------------------------------------------------------------------------------*/
/*	Register and Enqueue Template Scripts and Styles
/*-----------------------------------------------------------------------------------*/
 
function eq_add_modernizr() {
	
    wp_register_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.custom.js', false, '2.0.8' );
    wp_enqueue_script( 'modernizr' );

}  


function eq_add_IE9_script() {
		
	// If the current browser is IE8, enqueue a script that fixes many bugs and adds support for CSS 3 selectors in that same browser
	if ( stristr( $_SERVER['HTTP_USER_AGENT'], "msie 8" ) ) {
		wp_register_script( 'IE9_js', get_template_directory_uri() . '/js/IE9.js' );
    	wp_enqueue_script( 'IE9_js' );
 	}

}  


function eq_add_jquery() {
	
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js' );
    wp_enqueue_script( 'jquery' );
	
}  


function eq_add_portfolio_slider_js() {
		
	if ( is_page_template( 'template-home.php' ) || is_singular( 'portfolio' ) ) {
	    wp_enqueue_script( 'slides', get_template_directory_uri() . '/js/slides.min.jquery.js', array ( 'jquery' ) );
	}

}


function eq_add_superfish_script() {
	
	wp_register_script( 'superfish_js', get_template_directory_uri() . '/js/superfish.js', array( 'jquery' ), '1.4.8', true );
    wp_enqueue_script( 'superfish_js' );
	
}


function eq_add_quicksand() {
	
	if ( is_singular( 'portfolio' ) || is_page_template( 'template-home.php' ) ) {
			
		$number_of_projects_per_row = 4;
		
		wp_register_script( 'quicksand', get_template_directory_uri() . '/js/jquery.quicksand.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'quicksand' );
		
		wp_register_script( 'quicksand-init', get_template_directory_uri() . '/js/jquery.quicksand.init.js', array( 'jquery', 'quicksand' ), false, true );
		wp_enqueue_script( 'quicksand-init' );
	}
}  


function eq_add_hoverintent() {
	
    wp_register_script( 'hoverintent', get_template_directory_uri() . '/js/jquery.hoverintent.min.js', array( 'jquery' ), false, true );
    wp_enqueue_script( 'hoverintent' );
	
} 


function eq_add_jquery_easing() {
	
    wp_register_script( 'easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array( 'jquery' ), false, true );
    wp_enqueue_script( 'easing' );
	
} 


function eq_add_jquery_lavalamp() {
	
    wp_register_script( 'lavalamp', get_template_directory_uri() . '/js/jquery.lavalamp-1.3.5.min.js', array( 'jquery' ), '1.3.5', true );
    wp_enqueue_script( 'lavalamp' );
	
} 


function eq_add_jquery_scroll_to() {
	
    wp_register_script( 'scroll_to', get_template_directory_uri() . '/js/jquery.scrollTo-1.4.2-min.js', array( 'jquery' ), '1.4.2', true );
    wp_enqueue_script( 'scroll_to' );
	
} 


function eq_add_custom_header_jquery() {
	
	wp_enqueue_script( 'custom-header-js', get_template_directory_uri() . '/js/jquery.header.custom.js', array( 'jquery' ) );
	wp_localize_script( 'custom-header-js', 'headJS', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'templateurl' => get_template_directory_uri(), 'themePath' => get_template_directory_uri(), 'prevPost' => __( 'Go to the previous post', 'onioneye' ), 'nextPost' => __( 'Go to the next post', 'onioneye' ) ) );	
		
} 


function eq_add_custom_footer_jquery() {
	
    wp_register_script( 'custom-footer-js', get_template_directory_uri() . '/js/jquery.footer.custom.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'custom-footer-js' );
	
} 



/*-----------------------------------------------------------------------------------*/
/*	wp_head() scripts and styles
/*-----------------------------------------------------------------------------------*/

add_action( 'wp_enqueue_scripts', 'eq_add_modernizr', 5 ); 
add_action( 'wp_enqueue_scripts', 'eq_add_IE9_script', 10 );
add_action( 'wp_enqueue_scripts', 'eq_add_jquery', 15 );
add_action( 'wp_enqueue_scripts', 'eq_add_custom_header_jquery', 20 );
add_action( 'wp_enqueue_scripts', 'eq_add_portfolio_slider_js', 25 );
add_action( 'wp_enqueue_scripts', 'eq_add_jquery_easing', 30 );
add_action( 'wp_enqueue_scripts', 'eq_add_jquery_lavalamp', 35 );
add_action( 'wp_enqueue_scripts', 'eq_add_superfish_script', 40 ); 
add_action( 'wp_enqueue_scripts', 'eq_add_quicksand', 45 );
add_action( 'wp_enqueue_scripts', 'eq_add_hoverintent', 50 );
add_action( 'wp_enqueue_scripts', 'eq_add_jquery_scroll_to', 60 );
add_action( 'wp_enqueue_scripts', 'eq_add_custom_footer_jquery', 80 );

add_action( 'wp_footer', 'print_the_gmap_scripts' ); 



/* add the script for the google maps jQuery plugin, if the shortcode is embedded on the page */ 
function print_the_gmap_scripts() {
	
	global $add_the_gmap_scripts;
 
	if ( ! $add_the_gmap_scripts )
		return;
 
	wp_register_script( 'gmap-api', 'http://maps.google.com/maps/api/js?sensor=false', array( 'jquery' ), '1.0', true );
	wp_register_script( 'gmap-main-script', get_template_directory_uri() . '/js/jquery.gmap.min.js', array( 'jquery' ), '1.0', true );
	wp_print_scripts( 'gmap-api' );
	wp_print_scripts( 'gmap-main-script' );
}

?>
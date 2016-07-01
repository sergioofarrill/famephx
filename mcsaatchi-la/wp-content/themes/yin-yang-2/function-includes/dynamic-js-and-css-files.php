<?php

/*-----------------------------------------------------------------------------------*/
/* Output CSS to the custom.php file */
/*-----------------------------------------------------------------------------------*/

function eq_custom_css() {
	
	$body_bg_img = of_get_option( 'alt_pattern', 'none' );
	$body_background = of_get_option( 'body_bg', array( 'color' => '#fdfdfd', 'image' => '', 'repeat' => 'repeat', 'position' => 'top left', 'attachment' => 'scroll' ) );
		

	$output = "<?php header('Content-type: text/css'); ?>"; //set the appropriate content type for the file that is going to containt the custom css.
    $output .= "/*\tCustom Styles";
	$output .= "\n\t....................................................................................................................................... */\n";
	$output .= "\n\t";
	
	//set body background color and background image if defined; otherwise, set the background pattern
	if( $body_background ) {
		
		if ( $body_bg_img !== 'none' ) {
			$output .= "body { background: #fff url('../images/layout/" . $body_bg_img . "') repeat left top; }";
		}
		elseif ( $body_background['image'] && $body_background['color'] ) {
			$output .= "body { background: " . $body_background['color'] . " url('" . $body_background['image'] . "') " . $body_background['repeat'] . ' ' . $body_background['position'] . ' ' . $body_background['attachment'] . '; }';
		}
		elseif ( $body_background['image'] ) {
			$output .= "body { background: url('" . $body_background['image'] . "') " . $body_background['repeat'] . ' ' . $body_background['position'] . ' ' . $body_background['attachment'] . '; }';	
		}
		else { // only color
			$output .= "body { background: " . $body_background['color'] . '; }';
		}
		
	}
		
	// Output styles
	if ( $output <> '' ) {
		//get the absolute path to the file
		$file = get_theme_root() . '/' . get_template() . '/styles/custom.php';
		
		// Write the contents to the file 
		file_put_contents( $file, $output );
	}
}

?>
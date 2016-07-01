<?php 

/*-----------------------------------------------------------------------------------*/
/* Ajax
/*-----------------------------------------------------------------------------------*/

add_action( "wp_ajax_eq_get_ajax_project", "eq_get_ajax_project" );
add_action( "wp_ajax_nopriv_eq_get_ajax_project", "eq_get_ajax_project" );

function eq_get_ajax_project() {

    if ( !wp_verify_nonce( $_REQUEST['nonce'], "portfolio_item_nonce" ) ) {
    	exit("No naughty business please");
    }     
	
	$grid_classes = 'grid_9 alpha';
	$quality = 90;
	$desired_width = 700;
	$desired_height = 500;
	$current_post_id = $_REQUEST['post_id'];
	$video_embed_code = get_post_meta( $_REQUEST['post_id'], 'portfolio-video-embed', true );
	$portfolio_images = eq_get_the_portfolio_images( $_REQUEST['post_id'] );
	$terms = get_the_terms( $_REQUEST['post_id'] , 'portfolio_categories', 'string' );
	$content_post = get_post( $_REQUEST['post_id'] );
	$content = $content_post->post_content;
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]>', $content);
	$post = get_post( $current_post_id ); 
	$client = get_post_meta( $current_post_id, 'oy-client', true );
	$project_url = get_post_meta( $current_post_id, 'oy-item-url', true );
	
	ob_start();
?>

	<!-- START #single-item -->
	<section id="single-item" class="<?php echo $grid_classes; ?>">
			<?php 
			
			//display the video if present; otherwise, display the images
			if( $video_embed_code ) {
				
				echo stripslashes( htmlspecialchars_decode( $video_embed_code ) );	
					
			}
			else if( count( $portfolio_images ) === 1 ) {
				
				$portfolio_img_url = $portfolio_images[0];
				
				$image_details = wp_get_attachment_image_src( eq_get_attachment_id_from_src( $portfolio_img_url ), 'full');
				$image_full_width = $image_details[1];
				$image_full_height = $image_details[2];
										
				/* find the "desired height" of the current thumbnail, relative to the desired width  */
  				$desired_height = floor( $image_full_height * ( $desired_width / $image_full_width ) );
								    
				// If the original width of the thumbnail doesn't match the width of the slider, resize it; otherwise, display it in original size
				if( $image_full_width > $desired_width ) { 
			?>
										       		  	
					<img width="<?php echo $desired_width; ?>" height="<?php echo $desired_height; ?>" class="single-img single-img-ajax" src="<?php echo get_template_directory_uri() . '/timthumb.php?src=' . $image_details[0]; ?>&amp;h=<?php echo $desired_height; ?>&amp;w=<?php echo $desired_width; ?>&amp;q=90" alt="" />
					<div class="single-img-loader" style="width: <?php echo $desired_width; ?>px; height: <?php echo $desired_height; ?>px"></div>
					              
			<?php 
				} else { 
			?>
									              	
					<img width="<?php echo $image_full_width; ?>" height="<?php echo $image_full_height; ?>" class="single-img single-img-ajax" src="<?php echo $portfolio_img_url; ?>" alt="" />
					<div class="single-img-loader" style="width: <?php echo $image_full_width;; ?>px; height: <?php echo $image_full_height; ?>px"></div>
										              
			<?php 
				} 
			}
			else if ( count( $portfolio_images ) >= 1 ) {
				
			?>
				
				<!-- START .slider -->
				<section class="slider">
						
					<!-- START #slides -->
					<div id="slides">
						    	
				    	<!-- START .slides-container -->
						<div class="slides-container">
				
							<?php foreach ( $portfolio_images as $portfolio_img_url ) { ?>
										
						    	<!-- START .slide -->
							    <figure class="slide">
									    	
								    <?php 
								    	$image_details = wp_get_attachment_image_src( eq_get_attachment_id_from_src( $portfolio_img_url ), 'full');
								    	$image_full_width = $image_details[1];
										$image_full_height = $image_details[2];
										
								    	/* find the "desired height" of the current thumbnail, relative to the desired width  */
  										$desired_height = floor( $image_full_height * ( $desired_width / $image_full_width ) );
								    
									    // If the original width of the thumbnail doesn't match the width of the slider, resize it; otherwise, display it in original size
										if( $image_full_width > $desired_width ) { 
									?>
										       		  	
									    	<img width="<?php echo $desired_width; ?>" height="<?php echo $desired_height; ?>" class="slider-img" src="<?php echo get_template_directory_uri() . '/timthumb.php?src=' . $image_details[0]; ?>&amp;h=<?php echo $desired_height; ?>&amp;w=<?php echo $desired_width; ?>&amp;q=90" alt="<?php the_title(); ?>" />
										              
									<?php } else { ?>
										              	
											<img width="<?php echo $image_full_width; ?>" height="<?php echo $image_full_height; ?>" class="slider-img" src="<?php echo $portfolio_img_url; ?>" alt="<?php the_title(); ?>" />
										              
									<?php } ?>
													  										   
								</figure>
								<!-- END .slide -->
																      
							<?php } // end foreach ?>
							        							    
						</div> 
					    <!-- END .slides_container -->
						    	
					    <!-- START #next-prev-links -->
					    <div id="next-prev-links">
					       	<a href="#" class="prev"><img src="<?php echo get_template_directory_uri() ?>/images/layout/arrow-left.png" width="24" height="24" alt="Previous" /></a>
	        				<a href="#" class="next"><img src="<?php echo get_template_directory_uri() ?>/images/layout/arrow-right.png" width="24" height="24" alt="Next" /></a>
					    </div>
					    <!-- END #next-prev-links -->
						    
					</div>
				    <!-- END #slides -->
					    
				</section>
				<!-- END .slider -->
		
			<?php } ?>
		
		<?php if ( $content ) { ?>
		
			<div class="item-description">  			
				<?php echo $content; ?>
			</div>
		
		<?php } ?>
		
	</section>
	<!-- END #single-item -->
	
	<!-- START #portfolio-item-meta -->	
	<section id="portfolio-item-meta" class="grid_3 omega group">
		
		<?php
			
		$nonce_prev = wp_create_nonce("portfolio_item_nonce");
		$nonce_next = wp_create_nonce("portfolio_item_nonce");	
		
		?>
		
		<!-- START .post-nav -->
		<ul class="post-nav group">
			
			<li><span class="close-current-post">Close</span></li>
		
		<?php if ( $_REQUEST['prev_post_id'] && $_REQUEST['next_post_id'] ) { ?>			
		
			<li><a class="next-portfolio-post" rel="next" href="#" data-post_id="<?php echo $_REQUEST['next_post_id']; ?>" data-nonce="<?php echo $nonce_next; ?>">Next Post</a></li>
			<li><a class="prev-portfolio-post" rel="prev" href="#" data-post_id="<?php echo $_REQUEST['prev_post_id']; ?>" data-nonce="<?php echo $nonce_prev; ?>">Prev Post</a></li>
			
		<?php } else if ( $_REQUEST['prev_post_id'] ) { ?>
		
			<li><a class="prev-portfolio-post" href="#" data-post_id="<?php echo $_REQUEST['prev_post_id']; ?>" data-nonce="<?php echo $nonce_prev; ?>">Prev Post</a></li>

		<?php } else if ( $_REQUEST['next_post_id'] ) { ?>

			<li><a class="next-portfolio-post" href="#" data-post_id="<?php echo $_REQUEST['next_post_id']; ?>" data-nonce="<?php echo $nonce_next; ?>">Next Post</a></li>
	
		<?php } ?>
			
		</ul>
		<!-- END .post-nav -->
		
		<!-- START .section-title -->		
		<h2 class="project-title section-title"><?php echo get_the_title( $current_post_id ); ?></h2>
		<!-- END .section-title -->
			
		<?php if ( $terms ) { ?>	
						
			<ul class="item-categories group">
		    	<li><?php _e( 'Categories &rarr;', 'onioneye' ); ?> </li>
				<?php 
					foreach ( $terms as $term ) {
						echo '<li class="item-term">' . $term -> name . '</li>';
					}
				?>
			</ul>
				
		<?php } ?>
			
		<ul class="item-metadata">
		    <li><?php _e( 'Date &rarr;', 'onioneye' ); ?> </li>
		    <li><?php echo mysql2date( __( 'F Y', 'onioneye' ), $post->post_date ); ?></li>
		</ul>
		
		<?php if( $client ) { ?>
			
			<ul class="item-metadata">
			    <li><?php _e( 'Client &rarr;', 'onioneye' ); ?> </li>
			    <li><?php echo $client; ?></li>
			</ul>
			
		<?php } ?>
		
		<?php if( $project_url ) { ?>
			
			<ul class="item-metadata">
			    <li><?php _e( 'Project URL &rarr;', 'onioneye' ); ?> </li>
			    <li class="word-break"><a href="<?php echo $project_url; ?>" target="_blank"><?php echo $project_url; ?></a></li>
			</ul>
			
		<?php } ?>
					
	</section>
	<!-- END #portfolio-item-meta -->	
	
	<div class="portfolio-border grid_12 alpha omega group">&nbsp;</div>

<?php

 	$result['html'] = ob_get_clean();

   	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      	$result = json_encode($result);
      	echo $result;
   	}
   	else {
      	header("Location: ".$_SERVER["HTTP_REFERER"]);
   	}

   	die();

}


/*-----------------------------------------------------------------------------------*/
/* Get the id of the attachment by providing the source of the image. Needed for
 * finding the image's meta info, such as its width and height.
/*-----------------------------------------------------------------------------------*/

function eq_get_attachment_id_from_src( $image_src ) {
	
	global $wpdb;
	
	$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
	$id = $wpdb->get_var($query);
	
	return $id;
	
}


/*-----------------------------------------------------------------------------------*/
/* Add Body Classes for Layout
/*-----------------------------------------------------------------------------------*/

add_filter( 'body_class', 'eq_body_class' );
 
function eq_body_class( $classes ) {
	
	$sidebar_alignment = of_get_option( 'sidebar_alignment', 'two-cols-right-fixed' );
	
	$classes[] = $sidebar_alignment;
		
	return $classes;
	
}


/*-----------------------------------------------------------------------------------*/
/* General Settings */
/*-----------------------------------------------------------------------------------*/

/* Output the logo */

function eq_the_custom_logo() {
	
	$logo_url = of_get_option( 'custom_logo' );
	
	// If the logo is uploaded, get its size
	if ( $logo_url ) {			
		echo '<a href="' . get_home_url() . '" title="' . __( 'Return to the homepage', 'onioneye' ) . '">' .
			 	'<img src="' . $logo_url . '" alt="logo" />' . 
			 '</a>';
	}
	else {
		echo '<!-- START #wp-title-logo -->' .
			 '<a id="wp-title-logo" href="' . get_home_url() . '" title="' . __( 'Return to the homepage', 'onioneye' ) . '">' . get_bloginfo( 'title' ) . '</a>' .
			 '<!-- END #wp-title-logo -->';
	}
				
}



/* Output the URL of the current page */

function yy_the_current_page_url() {
	
	$page_url = 'http';
	
	if ( $_SERVER["HTTPS"] == "on" ) {
		$page_url .= "s";
	}
	
	$page_url .= "://";
		
	if ( $_SERVER["SERVER_PORT"] != "80" ) {
		$page_url .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
	} 
	else {
		$page_url .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	}
	
	return $page_url;
	
}



/* Add Favicon */

function yy_custom_favicon() {
	
	$favicon_url = of_get_option( 'custom_favicon' );
	
	if ( $favicon_url ) {
		echo '<link rel="shortcut icon" href="'.  $favicon_url  .'"/>'."\n";
	}
	else { ?>
		<link rel="shortcut icon" href="<?php echo bloginfo( 'stylesheet_directory' ) ?>/images/layout/favicon.ico" />
	<?php }	
	
}

add_action( 'wp_head', 'yy_custom_favicon' );



/*-----------------------------------------------------------------------------------*/
/* Social Networking */
/*-----------------------------------------------------------------------------------*/

function eq_get_the_social_networks() {

    $output = '';
	$social_networks = array ( 'twitter', 'facebook', 'flickr', 'vimeo', 'youtube', 'linkedin', 'googleplus', 'dribbble', 'tumblr', 'skype', 'delicious', 'digg', 'rss' );
	
	foreach ( $social_networks as $social_network ) {
		
		if ( $url = of_get_option( $social_network . '_url' ) ) {
				
			// Remove the URL filter on the skype link, to be able to use "callto://your_skype_id/", or similar values in the Skype URL field
			if ( $social_network !== 'skype' ) { 
				$output .= '<li><a target="_blank" id="' . $social_network . '-link" href="' . esc_url("{$url}") . '" title="' . $social_network . '">';    
			}
			else {
				$output .= '<li><a target="_blank" id="' . $social_network . '-link" href="' . "{$url}" . '" title="' . $social_network . '">'; 
			} 
 	  		
 	  		$output .= '<span class="inner"></span><span class="' . $social_network . ' social-icon"></span>';    
	 		$output .= "</a></li>\n";
		}
	}
    
    // Output Social Network Links
    if ($output <> '') {
      return $output;
    } 
	
}



/*-----------------------------------------------------------------------------------*/
/* Portfolio Meta Box Values */
/*-----------------------------------------------------------------------------------*/

function eq_get_the_preview_img_url() {
	
	global $post;
	$preview_img = get_post_meta( $post->ID, 'portfolio-preview-img', true );
	
	return $preview_img;
	
}

function eq_get_the_portfolio_video_embed_code() {
	
	global $post;
	$video_embed_code = get_post_meta( $post->ID, 'portfolio-video-embed', true );
	
	return $video_embed_code;
	
}

function eq_get_the_portfolio_images( $post_id ) {
		
	$img1 = get_post_meta( $post_id, 'portfolio-image-1', true );
	$img2 = get_post_meta( $post_id, 'portfolio-image-2', true );
	$img3 = get_post_meta( $post_id, 'portfolio-image-3', true );
	$img4 = get_post_meta( $post_id, 'portfolio-image-4', true );
	$img5 = get_post_meta( $post_id, 'portfolio-image-5', true );
	$img6 = get_post_meta( $post_id, 'portfolio-image-6', true );
	$img7 = get_post_meta( $post_id, 'portfolio-image-7', true );
	$img8 = get_post_meta( $post_id, 'portfolio-image-8', true );
	$img9 = get_post_meta( $post_id, 'portfolio-image-9', true );
	$img10 = get_post_meta( $post_id, 'portfolio-image-10', true );
	
	$meta_fields = array( $img1, $img2, $img3, $img4, $img5, $img6, $img7, $img8, $img9, $img10 );
	$image_urls = array();
	
	foreach($meta_fields as $meta_field) {
		if( $meta_field ) {
			$image_urls[] = $meta_field;
		}
	}
	
	return $image_urls;
	
}

function eq_get_the_client() {
	
	global $post;
	return get_post_meta( $post->ID, 'oy-client', true );
		
}

function eq_get_the_project_url() {
	
	global $post;
	return get_post_meta( $post->ID, 'oy-item-url', true );
	
}

?>
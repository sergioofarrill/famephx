<?php get_header(); ?>

<?php
	$grid_classes = 'grid_9 alpha';
	$quality = 90;
	$desired_width = 700;
	$desired_height = 500;
	$current_post_id = get_the_ID();
	$video_embed_code = get_post_meta( $current_post_id, 'portfolio-video-embed', true );
	$portfolio_images = eq_get_the_portfolio_images( $current_post_id );
	$client = get_post_meta( $current_post_id, 'oy-client', true );
	$project_url = get_post_meta( $current_post_id, 'oy-item-url', true );
	
	if ( have_posts() ) while ( have_posts() ) : the_post();
			
		$video_embed_code = eq_get_the_portfolio_video_embed_code();
		$terms = get_the_terms( $post->ID , 'portfolio_categories', 'string' ); 
		$content = get_the_content();
		
	endwhile; 
?>
	
	<!-- START #project-wrapper -->
    <div id="project-wrapper">
    	
    	<!-- START #single-item -->
		<section id="single-item" class="single-portfolio <?php echo $grid_classes; ?>">
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
											       		  	
						<img class="single-portfolio-img" width="<?php echo $desired_width; ?>" height="<?php echo $desired_height; ?>" class="single-img" src="<?php echo get_template_directory_uri() . '/timthumb.php?src=' . $image_details[0]; ?>&amp;h=<?php echo $desired_height; ?>&amp;w=<?php echo $desired_width; ?>&amp;q=90" alt="" />
											              
				<?php 
					} else { 
				?>
											              	
						<img class="single-portfolio-img" width="<?php echo $image_full_width; ?>" height="<?php echo $image_full_height; ?>" class="single-img" src="<?php echo $portfolio_img_url; ?>" alt="" />
											              
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
					<?php echo the_content(); ?>
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
			
			<?php 
			
			$adjacent_post = get_adjacent_post(false,'',true); 
			$prev_post_id = $adjacent_post->ID; 
			$adjacent_post = get_adjacent_post(false,'',false);
			$next_post_id =  $adjacent_post->ID; 
			$prev_post_link = '#';
			$next_post_link = '#';
			
			?>
			
			<?php if ( stristr( $_SERVER['HTTP_USER_AGENT'], "msie 8" ) ) { ?>
				
				<?php $prev_post_link = get_permalink( $prev_post_id ) . '#scroll'; ?>
				<?php $next_post_link = get_permalink( $next_post_id ) . '#scroll'; ?>
				
			<?php } else { ?>
				
				<li><span class="close-current-post">Close</span></li>
				
			<?php } ?>
			
			<?php if ( !empty( $prev_post_id ) && !empty( $next_post_id ) ) { ?>
				
				<li><a class="next-portfolio-post" rel="next" href="<?php echo $prev_post_link; ?>" data-post_id="<?php echo $prev_post_id; ?>" data-nonce="<?php echo $nonce_next; ?>">Next Post</a></li>
				<li><a class="prev-portfolio-post" rel="prev" href="<?php echo $next_post_link; ?>" data-post_id="<?php echo $next_post_id; ?>" data-nonce="<?php echo $nonce_prev; ?>">Prev Post</a></li>
				
			<?php } else if ( !empty( $prev_post_id ) ) { ?>
			
				<li><a class="next-portfolio-post" href="<?php echo $prev_post_link; ?>" data-post_id="<?php echo $prev_post_id; ?>" data-nonce="<?php echo $nonce_prev; ?>">Next Post</a></li>
	
			<?php } else if ( !empty( $next_post_id ) ) { ?>
	
				<li><a class="prev-portfolio-post" href="<?php echo $next_post_link; ?>" data-post_id="<?php echo $next_post_id; ?>" data-nonce="<?php echo $nonce_next; ?>">Prev Post</a></li>
		
			<?php } ?>
				
			</ul>
			<!-- END .post-nav -->
			
			<!-- START .section-title -->		
			
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
				
		
			
			<?php if( $project_url ) { ?>
				
				<ul class="item-metadata">
				    <li><?php _e( 'Project URL &rarr;', 'onioneye' ); ?> </li>
				    <li class="word-break"><a href="<?php echo $project_url; ?>" target="_blank"><?php echo $project_url; ?></a></li>
				</ul>
				
			<?php } ?>
					
		</section>
		<!-- END #portfolio-item-meta -->
		
		<div class="portfolio-border grid_12 alpha omega group">&nbsp;</div>	
	
	</div>
    <!-- END #project-wrapper -->
	
	<?php	
		$count = 0;
		$id_suffix = 1;
		$items_per_row = 4;
		$quality = 90;			   	   		
		$my_query = new WP_Query( array( 'posts_per_page' => '-1', 'post_type' => 'portfolio' ) );
		$grid_class = 'grid_3';
		$desired_width = 220;
		$desired_height = 190;
		$terms = get_terms( 'portfolio_categories' ); 
		$count_terms = count( $terms ); 
	?>
    
    <!-- START #project-wrapper -->
    <div id="project-wrapper"></div>
    <!-- END #project-wrapper -->
    
    <!-- START #portfolio-header -->
	<div id="portfolio-header" class="grid_12 alpha omega group <?php if( ! $intro_text ) echo 'no-intro'; ?>">  
		  
	    <h2><?php _e( 'Portfolio', 'onioneye' ); ?></h2>
		
		<!-- START #filter -->
		<ul id="filter" class="group">
			
			<!-- START .active -->
			
					
					<!-- START .term-count -->
					<span class="term-count">
						<?php echo wp_count_posts( 'portfolio' )->publish; ?>
						<span class="triangle-down"></span>
					</span>
					<!-- END .term-count -->
					
				</a>
			</li>
			<!-- END .active -->
				
			<?php if ( $count_terms > 0 ) { ?>
					
				<?php foreach ( $terms as $term ) { ?>
						
					<li>
						<a class="<?php echo $term->slug; ?>" href="#" title="<?php printf ( __( 'View all items filed under %s', 'onioneye' ), $term->name ); ?>">
	
							<span class="term-name"><?php echo $term->name; ?></span>
							
							<!-- START .term-count -->
							<span class="term-count"><?php echo $term->count; ?><span class="triangle-down"></span></span>
							<!-- END .term-count -->
							
						</a>
					</li>
					
				<?php } ?>
					
			<?php } ?>
			
		</ul>
		<!-- END #filter -->
		
	</div>	
	<!-- END #portfolio-header -->
		
	<!-- START .portfolio-gallery -->			
	<ul id="filterable-gallery" class="portfolio-gallery four-items-per-row grid_12 alpha omega">
		
	<?php while ( $my_query -> have_posts()) : $my_query -> the_post(); //query the "portfolio" custom post type for portfolio items ?>
			
		<?php $preview_img_url = eq_get_the_preview_img_url(); ?>
		<?php $count++; ?>
				
		<!-- START .portfolio-item -->
		<li data-id="id-<?php echo $id_suffix; ?>" <?php $terms = get_the_terms( $post -> ID, 'portfolio_categories' ); if ( !empty( $terms ) ) { echo 'data-group="'; foreach( $terms as $term ) { echo $term -> slug . ' '; } echo '"'; } ?> class="portfolio-item <?php echo $grid_class; ?> <?php if( $count === 1 ) { echo 'alpha'; } elseif( $count === $items_per_row ) { echo 'omega'; } ?>">
			
			<!-- START .project -->
			<figure class="project">   
					
				<?php $nonce = wp_create_nonce("portfolio_item_nonce"); ?>
   					
   				<!-- START .project-link -->
				<a class="project-link" href="<?php the_permalink(); ?>" data-post_id="<?php echo $post->ID; ?>" data-nonce="<?php echo $nonce; ?>">
				
					<?php if ( $preview_img_url ) { ?>
							
					<?php
						$image_details = wp_get_attachment_image_src( eq_get_attachment_id_from_src( $preview_img_url ), 'full');
						$image_full_width = $image_details[1];
						$image_full_height = $image_details[2];
										    
						// If the original width of the thumbnail doesn't match the width of the slider, resize it; otherwise, display it in original size
						if( $image_full_width > $desired_width || $image_full_height > $desired_height ) { 
					?>
						    <img width="<?php echo $desired_width; ?>" height="<?php echo $desired_height; ?>" src="<?php echo get_template_directory_uri() . '/timthumb.php?src=' . $image_details[0]; ?>&amp;h=<?php echo $desired_height; ?>&amp;w=<?php echo $desired_width; ?>&amp;q=<?php echo $quality; ?>" alt="<?php the_title(); ?>" />
						    				       		  								              
					<?php 
						} else { 
					?>			              	
							<img width="<?php echo $desired_width; ?>" height="<?php echo $desired_height; ?>" src="<?php echo $preview_img_url; ?>" alt="<?php the_title(); ?>" />					              
					<?php 
						} 
					?>
								    	
				    	<span class="project-overlay">View Details</span>
				    	
				    	<div class="project-content">
					    	<h3 class="project-caption"><?php the_title(); ?></h3> 
					    	<img class="view-button" src="<?php echo get_template_directory_uri(); ?>/images/layout/view-details.png" />
					    </div>
				    	
				    </a>
				    <!-- END .project-link -->
				    
				    <span class="blocked-project-overlay"></span>
				    				    
			    </figure>
			    <!-- START .project -->
			    			    
			<?php } ?>
					
		</li>  
		<!-- END .portfolio-item -->
						    
		<?php if( $count === $items_per_row ) { // if the current row is filled out with columns, reset the count variable ?>
			
			<?php $count = 0; ?> 
			 
		<?php } ?>
		<?php $id_suffix++; ?>
			
	<?php endwhile; ?>
			
	</ul>
	<!-- END .portfolio-gallery -->
	
	<?php if( of_get_option( 'client_logos' ) ) { // display the client logos if defined in the theme options panel ?>
		
		<div class="clients grid_12 alpha omega group">    
		    <h2><?php _e( 'Clients', 'onioneye' ); ?></h2>
		    
		    <img class="client-logos" src="<?php echo of_get_option( 'client_logos' ); ?>" alt="client logos" />
		</div>	
		
    <?php } ?>
    
    <script>
		(function($) {
			$( document ).one( "ready", function() {
				$( '.project-link[data-post_id="' + <?php echo json_encode( intval( $current_post_id ) ); ?> + '"]' ).next( '.blocked-project-overlay' ).addClass( 'overlay-active' );
				
				if ( $( 'body' ).hasClass('ie8') ) { 
					current_post_id = <?php echo json_encode( intval( $current_post_id ) ); ?>;
				}
			});	    		
		})( jQuery );
	</script>

<?php get_footer(); ?>
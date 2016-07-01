<?php
/*
Template Name: Home
*/
?>
<?php get_header(); ?>


<div class="mantra-container">
<div class="mantra">SIMPLICITY. IT'S OUR PRINCIPLE. OUR GUIDING LIGHT. OUR ONE WORD MANTRA. FROM HERE, INFECTIOUS STORIES UNFOLD.</div>
</div>

	<?php	
		$count = 0;
		$id_suffix = 1;
		$items_per_row = 4;
		$quality = 90;			   	   		
		$my_query = new WP_Query( array( 'posts_per_page' => '-1', 'post_type' => 'portfolio' ) );
		$grid_class = 'grid_3';
		$desired_width = 220;
		$desired_height = 190;
		$terms = get_terms( 'portfolio_categories', array( 'orderby' => 'menu_order' ) ); 
		$count_terms = count( $terms ); 
 
                $home_port_cat = of_get_option( 'dropdown_port_cats');
		$port_cat = get_term_by( 'id', $home_port_cat, 'portfolio_categories' );
		$pcat = $port_cat->slug; 

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
			<li class="active">
				<a href="#" class="all" style="visibility:hidden;" title="<?php _e('', 'onioneye' ); ?>">
					<span class="term-name"><?php _e( 'All', 'onioneye' ); ?></span>
					
	
					
				</a>
			</li>
			<!-- END .active -->
				
			<?php if ( $count_terms > 0 ) { ?>
					
				<?php foreach ( $terms as $term ) { ?>
						
					<li>
						<a class="<?php echo $term->slug; ?>" href="#" title="<?php printf ( __( '' ), $term->name ); ?>">
	
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
	
	<script>	
$(document).ready(function() {

	/* This is basic - uses default settings */
	
	$("a#team").fancybox();
	
	/* Using custom settings */
	
	$("a#inline").fancybox({
		'hideOnContentClick': true
	});

	/* Apply fancybox to multiple items */
	
	$("a.group").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	true
	});
	
});</script>

<div class="pod">
<div class="bio-pic"><a id="team" href="http://test.mcsaatchi-la.com/wp-content/uploads/2012/12/huw-bio-clr-3.jpg" ><img src="http://66.147.244.140/~mcsaatch/wp-content/uploads/2012/12/HUW_new-bw-e1368770802689.jpg" width="160" height="240" /></a></div>
<div class="bio-title">HUW GRIFFITH</div>
CEO, Partner
</div>


<?php if( of_get_option( 'client_logos' ) ) { // display the client logos if defined in the theme options panel ?>
		
		<div class="clients grid_12 alpha omega group">
  
		    <h2><?php _e( 'Clients', 'onioneye' ); ?></h2>
		    
		    <img class="client-logos" src="<?php echo of_get_option( 'client_logos' ); ?>" alt="client logos" />
		</div>	
		
    <?php } ?>



	<?php 
		global $wp_query;
		$pg = get_query_var('page_id');
		$args = array(
			'post_parent' => $pg,
			'post_type' => 'page',
			'post_status' => 'publish',
			'posts_per_page' => -1,
		);
		$pgquery = new WP_Query( $args );
		//var_export ( $pgquery );
		//if ( $pgquery->have_posts ) :
			while ( $pgquery->have_posts() ) : $pgquery->the_post();
				if ( has_post_thumbnail() ) { 
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
					$bgimg = 'style="background: url('.$thumb['0'].') 0px 50% no-repeat;"';
				}
				

					echo '<div class="entry-content grid_12 alpha omega" style="padding-bottom:10px;">';
						the_content();
					echo '</div>';
				        
			endwhile;
		//endif;
	?>








<?php get_footer(); ?>
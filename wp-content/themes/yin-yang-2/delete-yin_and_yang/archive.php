<?php get_header(); ?>

<?php 
	$sidebar_disabled = intval( of_get_option( 'blog_page_sidebar_disabled' ) ); 
	$image_width = ( $sidebar_disabled ) ? 160 : 140;
	$image_height = ( $sidebar_disabled ) ? 150 : 130;
	$quality = 90;
	$post_type = of_get_option( 'post_type' ); //get the post type; excerpt or full post.
?>	

	<!-- START #blog-posts -->
	<div id="blog-posts" <?php echo $grid = ( $sidebar_disabled ) ? '' : 'class="page-content"'; ?>>		
	
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			
			<!-- START .post -->
			<article id="post-<?php the_ID(); ?>" <?php post_class('post group'); ?>>
				
				<!-- START .post-meta -->
				<ul class="post-meta alpha <?php echo $grid = ( $sidebar_disabled ) ? 'grid_4 column-width' : 'grid_2'; ?>">
					
					<li class="post-time">
						<a href="<?php the_permalink(); ?>" rel="bookmark">
							<time pubdate>
								<?php 
									$pub_date = mysql2date( __( 'd M, Y', 'onioneye' ), $post->post_date ); 
									list($day, $month, $year) = split(' ', $pub_date);
								?>
								<span class="day"><?php echo $day; ?></span>
								<span class="month-and-year"><?php echo $month . ' ' . $year; ?></span>
							</time>
						</a>
					</li>
					
				</ul>
				<!-- END .post-meta -->
				
				<!-- START .post-content -->
				<div class="post-content omega <?php echo $grid = ( $sidebar_disabled ) ? 'grid_8 full-width-post' : 'grid_6 post-content-position'; ?>">
					
					<h2 class="post-title"><a href="<?php the_permalink(); ?>" class="post-title" rel="bookmark" title="<?php printf( __( 'Permanent Link to %s', 'onioneye' ), get_the_title()); ?>"><?php the_title(); ?></a></h2>
					
					<a href="<?php the_permalink(); ?>" rel="bookmark" class="featured-img-link">
						<?php 
							if ( has_post_thumbnail() ) {
							 
								if ( !$sidebar_disabled ) {
									the_post_thumbnail( array(520, 9999) );
								}
								else {
									the_post_thumbnail( array(620, 9999) );
								} 
							
							} 
						?>
					</a>
					
					<div class="excerpt-content">
						<?php if( $post_type === 'excerpt' ) { wpe_excerpt( 'wpe_excerptlength_index', 'new_excerpt_more' ); } else { the_content( __( 'Read The Rest', 'onioneye' ) ); } ?>
					</div>
					
					<ul class="additional-post-meta">
						<?php if( has_tag() ) { ?> 
							
							<li><?php the_tags( __('In: ', 'onioneye'), ', ', '' ); ?>&nbsp;&nbsp; &#8226; &nbsp;&nbsp;</li> 
							
						<?php } ?>
						
						<li><?php comments_popup_link( __('No Comments &#187;', 'onioneye' ), __( '1 Comment &#187;', 'onioneye' ), _n( '% comment', '% comments', get_comments_number(), 'onioneye' ) ); ?>&nbsp;&nbsp; &#8226; &nbsp;&nbsp;</li>
						<li class="author"><?php printf(__('by %s', 'onioneye'), get_the_author()); ?></li>
						<?php edit_post_link( __('Edit', 'onioneye'), '<li class="edit-post">&nbsp;&nbsp; &#8226; &nbsp;&nbsp;', '</li>' ); // Display the edit link, if logged in ?>
					</ul>
					
				</div>
				<!-- END .post-content -->
						
			</article>
			<!-- END .post -->
						
		<?php endwhile; ?>
		
		<!-- START .blog-pagination -->
		<section class="blog-pagination group alpha">
			<p>
				<?php next_posts_link( __('&laquo; Older Entries', 'onioneye' ) ); ?>
				<?php previous_posts_link( __( 'Newer Entries &raquo;', 'onioneye' ) ); ?>
			</p>
		</section>
		<!-- END .blog-pagination -->
	
	</div>
	<!-- END #blog-posts -->
	
	<?php if( ! $sidebar_disabled ) { ?>
		<?php get_sidebar( 'blog' ); ?>
	<?php } ?>
	
<?php get_footer(); ?>

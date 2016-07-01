	</div>
	<!-- END #content -->
	
	<?php 
		$social_networks = eq_get_the_social_networks();
		$footer_widgets_disabled = intval( of_get_option( 'footer_widgets_disabled', '0' ) ); 
		$number_of_widgets = intval( of_get_option( 'footer_columns', '4' ) );
				
		if ( $number_of_widgets === 4 ) {
			$grid_class = "grid_3";
		} 
		else if ( $number_of_widgets === 3 ) {
			$grid_class = "grid_4";
		}
		else if ( $number_of_widgets === 2 ) {
			$grid_class = "grid_6";
		}
	?>
	
	<!-- START #footer -->
	<footer id="footer" class="grid_12 group">
		
		<!-- START .footer-meta -->
		<div class="footer-meta grid_12 alpha omega">
			
			<?php if($social_networks) { ?>
				<!-- START #social-networking --> 
				<ul id="social-networking" class="grid_6 alpha">
					<?php echo $social_networks; ?>
				</ul>
				<!-- END #social-networking -->	
			<?php } ?>
					
			<div <?php if($social_networks) { ?>class="grid_6 omega"<?php } ?>>
				<small><?php echo of_get_option( 'copyright_text', __( 'Copyright Text', 'onioneye' ) ); ?></small>
			</div>
		</div>
		<!-- END .footer-meta -->
		
	</footer>
	<!-- END #footer -->
				
</div>
<!-- END #main-wrapper -->

<?php if( !$footer_widgets_disabled ) { ?>
	
	<!-- START .slide-out-div -->
	<div class="slide-out-div closed">
		
		<!-- START #slide-out-container -->	
		<div id="slide-out-container" class="container_12">
				
				<!-- START .footer-widgets -->
				<div class="footer-widgets grid_12">
					
						<?php for ( $i = 1; $i <= $number_of_widgets; $i++ ) { ?>
							
							<ul class="footer-widget <?php echo $grid_class; if(  $i == 1 ) { echo ' alpha'; } elseif ( $i == $number_of_widgets ) { echo ' omega'; } ?>">
								<?php if ( is_active_sidebar( 'bottom-' . $i ) ) : ?>
					          		
					          		<?php dynamic_sidebar( 'bottom-' . $i ); ?>
					          		
					          	<?php else: ?>
					          		
					          		<li><h4><?php _e( 'Widgetized Area', 'onioneye' ); echo ' ' + $i; ?></h4></li>
						          	<li>
						          		<p><?php _e( 'Go to Appearance &raquo; Widgets tab to overwrite this section. Use any widgets that fits you best. This is called ', 'onioneye' ); ?> 
						          		<strong><?php _e( 'Bottom', 'onioneye' ); echo ' ' . $i; ?></strong>.
						          		</p>
						          	</li>
						          	
								<?php endif; ?>
							</ul>
							
					    <?php } // end foreach ?>
						
				</div>
				<!-- END .footer-widgets -->
			
			<div id="overlay-handle" class="widgets-handle closed">&nbsp;</div>
			
			<!-- START #back-to-top -->
			<a id="back-to-top" class="main-top-button" href="#top">
				<span class="inner"></span>
				<img width="38" height="38" src="<?php echo get_template_directory_uri(); ?>/images/layout/top-button.png" alt="Back to top" />
			</a>
			<!-- END #back-to-top -->
			
		</div>
		<!-- END #slide-out-container -->
		
	</div>
	<!-- END .slide-out-div -->
	
<?php } else { ?>
	
	<!-- START #back-to-top -->
	<a id="back-to-top" class="alternative-top-button" href="#top">
		<span class="inner"></span>
		<img width="38" height="38" src="<?php echo get_template_directory_uri(); ?>/images/layout/top-button.png" alt="Back to top" />
	</a>
	<!-- END #back-to-top -->
	
<?php } ?>

<div id="overlay"></div>


<!-- START wp_footer -->
<?php wp_footer(); ?>
<!-- END wp_footer -->

<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-T98DL2"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-T98DL2');</script>
<!-- End Google Tag Manager -->

<script type="text/javascript">
/* The first line waits until the page has finished to load and is ready to manipulate */
jQuery(document).ready(function($){
    /* remove the 'title' attribute of all <img /> tags */
    $("img").removeAttr("title");
});
</script>



</body>
</html>
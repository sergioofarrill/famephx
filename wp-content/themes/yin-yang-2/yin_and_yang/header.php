<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	
	<!-- title -->
	<title><?php wp_title( '&laquo;', true, 'right' ); ?><?php bloginfo( 'name' ); ?></title>
	
	<!-- meta tags -->
	<meta name="description" content="<?php bloginfo( 'description' ); ?>" />
	<meta name="author" content="onioneye" />
	<meta name="author-url" content="http://www.onioneye.com" />
  	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  	
  	<!-- RSS and pingback -->
  	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> Feed" href="<?php echo home_url(); ?>/feed/">
  	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<!-- main stylesheets -->
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_directory' ); ?>/styles/custom.php?ver=<?php of_file_version( 'styles/custom.php' ); ?>" />	
	
	<!-- print stylesheet -->
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_directory' ); ?>/styles/print.css" media="print" />
	
	<!-- google fonts -->
	<link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:300' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
	
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
		
	<!-- wp head -->
	<?php wp_head(); ?>
	<!-- wp head end -->
</head>

<!--[if IE 8 ]> <body <?php body_class( 'ie ie8' ); ?>> <![endif]-->
<!--[if IE 9 ]> <body <?php body_class( 'ie ie9' ); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <body <?php body_class(); ?>> <!--<![endif]-->
	
	<?php if( of_get_option( 'dropdown_page', 'Select a Page:') !== 'Select a Page:' ) { ?>
	
		<!-- START #dropdown-wrapper --> 
		<div id="dropdown-wrapper">
			<div class="container_12 group">
				<!-- START .dropdown-page --> 
		 		<div class="dropdown-page grid_12 group">
		 			<?php
					$page_data = get_page( of_get_option( 'dropdown_page' ) );
					$content = apply_filters('the_content', $page_data->post_content); // Get Content and retain Wordpress filters such as paragraph tags.
					echo $content;
					?>
				</div>
				<!-- END .dropdown-page --> 
			</div>
		</div>
		<!-- END #dropdown-wrapper --> 
	
	<?php } ?>
	
	<!-- START #main-wrapper --> 
	<div id="main-wrapper" class="container_12 group">
	
		<!-- START #header -->
	 	<header id="header" class="grid_12 group">
			
			<!-- START Custom Menu -->
			<?php wp_nav_menu( array( 'theme_location' => 'main', 'container' => 'nav', 'menu' => 'custom_menu', 'container_id' => 'menu', 'container_class' => 'group', 'depth' => 2, 'walker' => new Nfr_Menu_Walker() ) ); ?>
			<!-- END Custom Menu -->
						
			<?php if( of_get_option( 'dropdown_page', 'Select a Page:') !== 'Select a Page:' ) { ?>
				<!-- START #dropdown-trigger -->
				<div id="dropdown-trigger"><?php $page = get_post( of_get_option( 'dropdown_page', '') ); echo $page->post_title; ?><span class="drop-down-arrows">&nbsp;</span></div>
				<!-- END #dropdown-trigger -->
			<?php } ?>
			
			<!-- START .branding -->
			<div id="branding" class="grid_12 alpha omega group">
				
				<!-- START #logo -->
				<div id="logo">
					<?php eq_the_custom_logo(); ?>
				</div>
				<!-- END #logo -->
				
				<!-- START #intro-section -->
				<div id="intro-section">
			    	<h1 id="main-headline"><?php echo of_get_option( 'intro_text' ); ?></h1>
			    </div>
			    <!-- END #intro-section -->
				
			</div>
			<!-- END .branding -->
			
		</header>
		<!-- END #header -->
				  	
		<!-- START #content --> 
		<div id="content" class="grid_12 group">	
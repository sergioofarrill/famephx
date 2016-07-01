<?php
	if (!function_exists('wp_get_current_user'))
		include("../../../../wp-load.php"); 
?><!DOCTYPE HTML>
<html>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<head>
	<link href="http://mcsaatchi-la.com/wp-content/uploads/2013/08/favicon.png" rel="icon" type="image/x-icon" />
	<meta http-equiv="refresh" content="8; url=http://mcsaatchi-la.com/"> 
	<meta charset="UTF-8">
	<title></title>
	<style>

		body {background:<?php echo get_option('background_color_ss', '#000');?>; color:#fff; margin:0; padding:0}
		header {position:; z-index:2; height:40px; line-height:40px; background:#fff; top:0; left:0; right:0; text-align:right; padding:0 20px 0}
		header a {text-decoration:none; color:#000; font-family:'Arial'; font-size:14px}
		header a:hover, header a:focus {text-decoration:underline}
		#link_redirect { display:block; background-image:url(<?php echo get_option('upload_image_ss');?>); 
			background-position:<?php echo get_option('bg_position_ss', 'center top');?>; text-align:center; z-index:1}

	<?php echo get_option('css_ss', '');?>
	</style>
</head>

<body class="splash_screen">
	<div id="page_effect" style="display:none;">

		<header>
			<a href=""><?php echo get_option('acceder_button_ss', 'Accéder directement au site');?></a>
		</header>
	

	<div class="frame-b"></div>
	<div class="frame-t"></div>
	<div class="frame-l"></div>
	<div class="frame-r"></div>
	<div class="content"></div>

		<a class="link_redirect" href="<?php echo get_option('url_redirect_ss', '');?>">
			<?php 
				if (get_option('etirer_image_ss', 'off') == 'on')
					echo '<img src="'.get_option('upload_image_ss').'" width="100%" height="100%" alt="" />';
			?>
		</a>

	</div>
	
<script type="text/javascript">
	$(document).ready(function(){
		$('#page_effect').fadeIn(2000);
	}); 
</script>

</body>
</html>
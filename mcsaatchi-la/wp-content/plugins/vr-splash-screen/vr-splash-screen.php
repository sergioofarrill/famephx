<?php
	/*
	  Plugin Name: Splash Screen
	  Plugin URI: http://www.vincent-rousseau.net/content/plugin-vr-splash-screen-wordpress
	  Description: -
	  Author: Vincent Rousseau
	  Version: 1.0.4
	  Author URI: http://www.vincent-rousseau.net/
	 */

	class vr_splash_screen {
		
		const LANG_DIR = '/lang/';

		function __construct() {
			add_action('init', array($this, 'vrss_init')); // Init
			add_action('admin_menu', array($this, 'vrss_admin_menu')); // Menu
			add_action('admin_init', array($this, 'vrss_admin_init')); // Admin Init
			add_action('admin_print_scripts', array($this, 'vrss_admin_print_scripts')); // Scripts
			add_action('admin_print_styles', array($this, 'vrss_admin_print_styles')); // CSS
			add_action('template_redirect', array($this, 'vrss_template_redirect')); // Template front
		}

		function vrss_admin_menu() {
			add_menu_page('Splash Screen', 'Splash Screen', 'administrator', 'vrss_config', array($this, 'page_vrss_config'), '');
		}
		
		function vrss_init() {
			if (isset($_REQUEST['page']) && $_REQUEST['page'] == 'vrss_config')
				load_plugin_textdomain('vr-splash-screen', false, dirname(plugin_basename( __FILE__ ) ) . self::LANG_DIR);
		}

		function vrss_admin_init() {
			register_setting('vrss', 'activer_ss');
			register_setting('vrss', 'background_color_ss');
			register_setting('vrss', 'upload_image_ss');
			register_setting('vrss', 'bg_position_ss');
			register_setting('vrss', 'url_redirect_ss');
			register_setting('vrss', 'css_ss');
			register_setting('vrss', 'cookie_ss');
		}

		function page_vrss_config() {
			global $_POST;
			
			if ($_POST) {
				foreach ($_POST as $index => $value) {
					if ($index == 'upload_image_ss') {
						if ($index && $value) {
							$value = stripslashes(trim($value));
							update_option($index, $value);
						}
					}
					else {
						$value = stripslashes(trim($value));
						update_option($index, $value);
					}
				}
				
				if (!isset($_POST['activer_ss']))
					update_option('activer_ss', 'off');
					
				if (!isset($_POST['etirer_image_ss']))
					update_option('etirer_image_ss', 'off');
					
				
				$_GET["updated"] = true;
			}
			
			require_once('html/vrss_config.php');
		}

		function vrss_admin_print_scripts() {
			if (isset($_REQUEST['page']) && $_REQUEST['page'] == 'vrss_config') {
				wp_enqueue_script('media-upload');
				wp_enqueue_script('thickbox');
				wp_register_script('my-upload', WP_PLUGIN_URL.'/vr-splash-screen/js/functions.js', array('jquery','media-upload','thickbox'));
				wp_enqueue_script('my-upload');
			}
		}

		function vrss_admin_print_styles() {
			if (isset($_REQUEST['page']) && $_REQUEST['page'] == 'vrss_config')
				wp_enqueue_style('thickbox');
		}

		function vrss_template_redirect() {
			if (get_option('activer_ss', 'off') == 'on' && $this->vrss_is_first_visit()) {
				$tpl_file = WP_PLUGIN_URL . '/vr-splash-screen/template/splash_screen.php';
				echo file_get_contents($tpl_file);
				exit;
			}
		}

		function vrss_is_first_visit() {
			global $visited;
			 
			if (!is_admin()) {
				if (isset($_COOKIE['visited'])) 
					$visited = $_COOKIE['visited'] + 1;
				else
					$visited = 1;
				 
				$url = parse_url(get_option('home'));
				if (is_numeric(get_option('cookie_ss', 86400)))
					$time_cookie = get_option('cookie_ss', 86400);
				else
					$time_cookie = 86400;
					
				setcookie('visited', $visited, time() + $time_cookie, $url['path'].'/');
			}
			else 
				return false;
			 
			return $visited == 1;
		}
	}

	if (class_exists('vr_splash_screen'))
	   $vr_splash_screen = new vr_splash_screen();
?>
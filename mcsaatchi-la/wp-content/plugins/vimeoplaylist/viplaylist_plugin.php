<?php
/*
        Plugin Name: Vimeo SEO Playlist
        Plugin URI: http://www.cfcms.nl/vimeo/
        Description: Vimeo playlist SEO plugin. Go to <a href="./options-general.php?page=Vimeoplaylist"><b>settings - Vimeo Playlist</b></a> for the overall settings and the shortcodes
        Version: 3.0
        Author: Ceasar Feijen
        Author URI: http://www.cfconsultancy.nl
        License: Copyright © 2012 cfconsultancy
        This is not free software !
*/

require_once('viplaylist_plugin_class.php');

// write default plugin options to the database on plugin activation
register_activation_hook( __FILE__, VimeoPlaylistPlugin::add_handler('hook_plugin_activate') );
register_deactivation_hook( __FILE__, VimeoPlaylistPlugin::add_handler('hook_plugin_deactivate'));

// add plugin settings menu item to the wordpress admin area
add_action( 'admin_menu', VimeoPlaylistPlugin::add_handler('hook_admin_menu') );

// add setting link
function viplaylist_links($links, $file) {
    static $this_plugin;

    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }

    // check to make sure we are on the correct plugin
    if ($file == $this_plugin) {
        // the anchor tag and href to the URL we want. For a "Settings" link, this needs to be the url of your settings page
        $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/options-general.php?page=vimeoplaylist">Settings</a>';
        // add the link to the list
        array_unshift($links, $settings_link);
    }

    return $links;
}

add_filter('plugin_action_links', 'viplaylist_links', 10, 2);

// [vimeolist feed=keywords sort=relevance cache=false]
add_shortcode( 'vimeolist', VimeoPlaylistPlugin::add_handler('hook_shortcode') );

// add init hook to load plugin scripts and stylesheets
add_action('init', VimeoPlaylistPlugin::add_handler('hook_plugin_init'));

// add JS and css for the admin
function addAdminScriptsVimeo() {

    if(isset($_GET['page'])) {
        $get_page = $_GET['page'];
        if($get_page == 'vimeoplaylist') {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('farbtastic');
        wp_register_script('vimeoplaylist-admin', plugins_url( 'lib/vimeoplaylist-admin.js', __FILE__ ), false, '1', true);
        wp_enqueue_script('vimeoplaylist-admin');
        wp_register_style('vimeoplaylist-admin', plugins_url( 'lib/vimeoplaylist-admin.css', __FILE__ ), false, '1', 'screen');
        wp_enqueue_style('vimeoplaylist-admin');
		wp_enqueue_style('farbtastic');
        }
    }

}
add_action('init', 'addAdminScriptsVimeo');
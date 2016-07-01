<?php
/*
        License: Copyright © 2012 cfconsultancy
        This is not free software !
*/

class VimeoPlaylistPlugin
{
        const UUvID = "vimeoplaylist";
        const VIPLIST = 'viplaylist';

        /**
         * A list of all the settings for this plugin.
         * The array is divided in two sub arrays, php and js.
         * The user is able to override the settings in the "php" subarray through wordpress shortcode attributes.
         * The user cannot override the "js" settings, site wide defaults can be configured within the admin environment.
         *
         *
         */
        private static $plugin_settings = array(
                "js" => array(
                        "playerWidth" => array(
                                "name" => "Player Width",
                                "desc" => "<br />In pixels. The width of the embedded vimeo video. <br />The player height is determined based on this width. Default is 450",
                                "default" =>"450",
                        ),
                        "centerPlayer" => array(
                                "name" => "Center Player",
                                "desc" => "<br />Whether or not to center the player in the parent container",
                                "values" => array(true,false),
                                "default" => true
                        ),
                        "thumb_right" => array(
                                "name" => "Playlist to the right",
                                "desc" => "<br />Playlist to the right of the player",
                                "values" => array(true,false),
                                "default" => false
                        ),
                        "color" => array(
                                "name" => "Player controll colors",
                                "desc" => "<div id='color_picker_color1'></div>",
                                "default" =>"#f2f2f2",
                        ),
                        "colorbg" => array(
                                "name" => "BG color",
                                "desc" => "<div id='color_picker_color2'></div>",
                                "default" =>"#f2f2f2",
                        ),
                        "autoPlay" => array(
                                "name" => "Auto Play",
                                "desc" => "<br />Set to true to play automatic with onclick",
                                "values" => array(true,false),
                                "default" =>true
                        ),
                        "playOnLoad" => array(
                                "name" => "Play on Load",
                                "desc" => "<br />Play first video automatic with page onload",
                                "values" => array(true,false),
                                "default" =>false
                        ),
                        "playfirst" => array(
                                "name" => "Play first",
                                "desc" => "<br />Select the video to start with. 0 is the first, 1 the second ect",
                                "default" =>"0",
                        ),
                        "sliding" => array(
                                "name" => "Sliding playlist",
                                "desc" => "<br />Set to true to let the list scroll up and show the arrows (default = true)",
                                "values" => array(true,false),
                                "default" =>true
                        ),
                        "listsliding" => array(
                                "name" => "list sliding",
                                "desc" => "<br />Set to true to let the playlist scroll up",
                                "values" => array(true,false),
                                "default" =>true
                        ),
                        "slideshow" => array(
                                "name" => "slide show",
                                "desc" => "<br />Set to true to play the complete playlist one after another in a continues loop",
                                "values" => array(true,false),
                                "default" =>false
                        ),
                        "playlistheight" => array(
                                "name" => "Visible playlist items",
                                "desc" => "<br />How many visible items to show in the playlist (default = 3)",
                                "values" => array("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20"),
                                "default" =>"3",
                        ),
                        "social" => array(
                                "name" => "Show social icons",
                                "desc" => "<br />Facebook and twitter icons with mouseover video. Set to false ro remove (default = true).",
                                "values" => array(true,false),
                                "default" =>true
                        ),
                        "portrait" => array(
                                "name" => "Portrait",
                                "desc" => "<br />Show the user’s portrait on the video",
                                "values" => array(true,false),
                                "default" =>false
                        ),
                        "title" => array(
                                "name" => "Video title",
                                "desc" => "<br />Show the title on the video",
                                "values" => array(true,false),
                                "default" =>false
                        ),
                        "byline" => array(
                                "name" => "Byline",
                                "desc" => "<br />Show the user’s byline on the video",
                                "values" => array(true,false),
                                "default" =>false
                        ),
                        "loop" => array(
                                "name" => "video loop",
                                "desc" => "<br />Set to true to play the video again when it reaches the end",
                                "values" => array(true,false),
                                "default" =>false
                        )
                ),
                "php" => array(
                        "type" => array(
                                "name" => "Choose feed type",
                                "desc" => "<br />Choose which feed type you want. Use the shortcodes to set this on each page. Default is videos (See on top of the page)",
                                "values" => array("videos","likes","appears_in","all_videos","subscriptions","album","channel","group"),
                                "default" => "videos"
                        ),
                        "cache" => array(
                                "name" => "Cache",
                                "desc" => "<br />Cache the xml feed(true or false). Make sure the dir cache has rights to write to.",
                                "values" => array(true,false),
                                "default" => false
                        ),
                        "cachelife"        => array(
                                "name" => "Cache Life",
                                "desc" => "<br />Empty cached xml for example after one hour 3600, one day 86400 or one week 604800 (in seconds)",
                                "default" => "86400"
                        ),
                        "desclength" => array(
                                "name" => "Description Length",
                                "desc" => "<br />Description Length. If you make the width of the player smaller you can set here the max. characters (Default 200)",
                                "default" => ""
                        ),
                        "titlelength" => array(
                                "name" => "Title Length",
                                "desc" => "<br />Title Length. If you make the width of the player smaller you can set here the max. characters (Default 70)",
                                "default" => "70"
                        )
                )
        );

        /**
         *
         * This hook runs only once when the plugin gets activated.
         *
         * It extracts all the default values from the static $plugin_settings array
         * and writes them to the database.
         *
         */
        function hook_plugin_activate()
        {
                $default_plugin_settings = array();

                foreach( self::$plugin_settings['js'] as $key => $value )
                        $default_plugin_settings['js'][$key] = $value['default'];

                foreach( self::$plugin_settings['php'] as $key => $value )
                        $default_plugin_settings['php'][$key] = $value['default'];

                update_option( self::VIPLIST, $default_plugin_settings );
        }

        /**
         *
         * Delete all the plugin options from the database on deactivation
         *
         */
        function hook_plugin_deactivate()
        {
                delete_option(self::VIPLIST);
        }

        /**
         *
         * - Make sure jquery is included in wordpress.
         * - Add youtubeplaylist css file to the document (depends on presence of wp_head() in theme file)
         * - Add youtubeplaylist js file to the document (depends on presence of wp_head() and jquery in theme file)
         *
         */
        function hook_plugin_init()
        {
        if (!is_admin()) {
                wp_enqueue_style( 'viplaylist_style', plugins_url('/css/vimeoplaylist.css', __FILE__), null, '1', 'all' );
                wp_enqueue_style( 'viplaylist_style_thumbs', plugins_url('/css/vimeoplaylist-right-with-thumbs.css', __FILE__), null, '1', 'all' );
                wp_enqueue_script( 'jquery' );
                wp_enqueue_script('viplaylist_script', plugins_url('/js/jquery.vimeoplaylist.min.js', __FILE__), null, '1' , true );
        }
        }

        /**
         *
         * Render a menu item in the Wordpress admin environment called 'Youtube Playlist' under 'Settings'
         *
         */
        function hook_admin_menu()
        {
                add_options_page(
                        'Vimeo Playlist Options',
                        'Vimeo Playlist',
                        'manage_options',
                        self::UUvID,
                        self::add_handler('render_options_page')
                );

                add_action( 'admin_init', self::add_handler('admin_init_callback') );
        }

        /**
         *
         * This function is called whenever a shortcode of the type [youtube-list] is found in Wordpress content.
         *
         * It converts the shortcode to a combination of html and javascript to output the Youtube Video player
         *
         */
        function hook_shortcode( $atts )
        {
                $defaults = get_option( self::VIPLIST );
                $options = shortcode_atts( $defaults["php"], $atts );

                require_once('class/class.vimeolist.php');

                $video = new vimeolist('userlist');

                $video->set_username($atts["username"]);

                if( !empty($atts["type"]) )
                    	$video->set_feedtype($atts["type"]);
                   else
                    	$video->set_feedtype($options["type"]);

                $video->set_cachexml((bool)$options["cache"]);

                $video->set_cachelife($options["cachelife"]);

                $video->set_xmlpath(__DIR__."/cache/");

                $video->set_descriptionlength( $options["desclength"] );

                $video->set_titlelength( $options["titlelength"] );

                ob_start();
                $defaults["js"]["holderId"] = "vivideo";

	            if( !empty($atts["playerwidth"]) ) {
	               $defaults["js"]["playerWidth"] = $atts["playerwidth"];
	            }

	            if( !empty($atts["color"]) ) {
	               $defaults["js"]["color"] = $atts["color"];
	            }

	            if( !empty($atts["colorbg"]) ) {
	               $defaults["js"]["colorbg"] = $atts["colorbg"];
	            }

	            if( !empty($atts["thumb_right"]) ) {
	               $defaults["js"]["thumb_right"] = $atts["thumb_right"];
	            }

	            if( !empty($atts["slideshow"]) ) {
	               $defaults["js"]["slideshow"] = $atts["slideshow"];
	            }

	            if( !empty($atts["portrait"]) ) {
	               $defaults["js"]["portrait"] = $atts["portrait"];
	            }

	            if( !empty($atts["title"]) ) {
	               $defaults["js"]["title"] = $atts["title"];
	            }

	            if( !empty($atts["byline"]) ) {
	               $defaults["js"]["byline"] = $atts["byline"];
	            }

	            if( !empty($atts["loop"]) ) {
	               $defaults["js"]["loop"] = $atts["loop"];
	            }

	            if( !empty($atts["centerPlayer"]) ) {
	               $defaults["js"]["centerPlayer"] = $atts["centerPlayer"];
	            }

	            if( $defaults["js"]["thumb_right"] == 1 ) {
	               $defaults["js"]["sliding"] = false;
	            }

                if ( $defaults["js"]["thumb_right"] == 1 ) {
                	$video->set_descriptionlength( $options["desclength"] / 0 );
                	$video->set_titlelength( $options["titlelength"] / 3  );
                }

	            if( !empty($atts["playlistheight"]) ) {
	               $defaults["js"]["playlistheight"] = $atts["playlistheight"];
	            }

                $playlistheight = $defaults["js"]["playlistheight"]*77;

                $defaults["js"]["playerHeight"] = (int) ceil( intval($defaults["js"]["playerWidth"])/16*9 );

                $defaults["js"]["color"] = str_replace("#", "",  $defaults["js"]["color"]);

                if ($defaults["js"]["thumb_right"] == 0) {

                ?>
                <script type="text/javascript">
                	jQuery(document).ready(function($)
                    {
                      $(".videoThumbvim").viplaylist(<?php echo json_encode($defaults["js"]); ?>);
                    });
                </script>
                        <div id="vimeo_holder" style="<?php if(!empty($defaults["js"]["colorbg"])){echo "background:{$defaults["js"]["colorbg"]};border:{$defaults["js"]["colorbg"]};";}?><?php echo($defaults["js"]["centerPlayer"])?"margin-left:auto;margin-right:auto;":""; echo (!empty($defaults["js"]["playerWidth"]))?"width:{$defaults["js"]["playerWidth"]}px;":"";?>">
                             <div id="<?php echo $defaults["js"]["holderId"]; ?>" <?php if(!empty($defaults["js"]["playerHeight"])){echo "style=\"height:{$defaults["js"]["playerHeight"]}px;\"";}?> class="ytvideoright"></div>
	                            <div class="you_up"><img src="<?php echo WP_PLUGIN_URL . '/vimeoplaylist/css/up_arrow.png'; ?>" alt="+ Slide" title="HIDE" /></div>
	                            <div class="you_down"><img src="<?php echo WP_PLUGIN_URL . '/vimeoplaylist/css/down_arrow.png'; ?>" alt="- Slide" title="SHOW" /></div>
                                 <div class="vimplayer">
                                        <ul class="videovim" <?php if(!empty($defaults["js"]["playerWidth"])){echo "style=\"width:{$defaults["js"]["playerWidth"]}px;";}?><?php if(!empty($defaults["js"]["playlistheight"])){echo "height:{$playlistheight}px;\"";}?>>
                                                <?php
                                                if( $video->get_videos() !=null )
                                                {
                                                    foreach( $video->get_videos() as $key => $val )
                                                    {
                                                    	echo sprintf('<li><p class="vimtitle">%s</p><span class="time">%s</span><a class="videoThumbvim" title="%s" href="http://vimeo.com/%s"><img width="100" height="75" alt="%s" src="%s" />%s</a></li>',$val['title'],$val['time'],htmlspecialchars($val['title']),$val['videoid'],htmlspecialchars($val['title']),$val['thumbnail_small']);
                                                    }
                                                }
                                                else
                                                {
                                                	echo '<li>Sorry, no video\'s found</li>';
                                                }
                                                ?>
                                        </ul>
                                </div>
                        </div>
                        <div style="clear:both;">&nbsp;</div>

                <?php
                } else {

                $thumb_width = $defaults["js"]["playerWidth"] + 307;
                $thumb_height = $defaults["js"]["playerHeight"] - 4;

                ?>

              <script type="text/javascript">
                	jQuery(document).ready(function($)
                        {
                        $(".videoThumbvim").viplaylist(<?php echo json_encode($defaults["js"]); ?>);
                        });
                </script>
                      <div <?php if(!empty($thumb_width)){echo "style=\"width:{$thumb_width}px;\"";}?>>
                        <div id="vimeo_holder" style="padding-bottom:10px;<?php if(!empty($defaults["js"]["playerHeight"])){echo "height:{$defaults["js"]["playerHeight"]}px;";}?><?php if(!empty($thumb_width)){echo "width:{$thumb_width}px;";}?><?php if(!empty($defaults["js"]["colorbg"])){echo "background:{$defaults["js"]["colorbg"]};border:{$defaults["js"]["colorbg"]};";}?><?php echo($defaults["js"]["centerPlayer"])?"margin-left:auto;margin-right:auto;":"";?>">
                                <div id="<?php echo $defaults["js"]["holderId"]; ?>" style="<?php if(!empty($defaults["js"]["playerHeight"])){echo "height:{$defaults["js"]["playerHeight"]}px;";}?> <?php if(!empty($defaults["js"]["playerWidth"])){echo "width:{$defaults["js"]["playerWidth"]}px;";}?>;float:left;" class="vimvideoright"> </div>
                                <div class="vimplayer vimplayerright">
                                        <ul class="videovim videovimright" <?php if(!empty($thumb_height)){echo "style=\"height:{$thumb_height}px;\"";}?>>
                                                <?php
                                                if( $video->get_videos() !=null )
                                                {
                                                        foreach( $video->get_videos() as $key => $val )
                                                        {
                                                                echo sprintf('<li><p class="vimtitle vimtitle_right">%s</p><span class="time timeright">%s</span><a class="videoThumbvim" title="%s" href="http://vimeo.com/%s"><img width="100" height="75" alt="%s" src="%s" />%s</a></li>',$val['title'],$val['time'],htmlspecialchars($val['title']),$val['videoid'],htmlspecialchars($val['title']),$val['thumbnail_small'],$val['description'] );
                                                        }
                                                }
                                                else
                                                {
                                                        echo '<li>Sorry, no video\'s found</li>';
                                                }
                                                ?>
                                        </ul>
                                </div>
                        </div>
                        <div style="clear:both;">&nbsp;</div>
                       </div>

                <?php
                }

                $result = ob_get_clean();
                return $result;
        }

        /**
         *
         * Register a unique key for storing plugin settings in a row of the wp_options table.
         *
         * Adds two sections to the Vimeo Playlist options page in the admin environment.
         * - one for js settings
         * - one for php settings
         *
         */
        function admin_init_callback()
        {
                register_setting( self::VIPLIST, self::VIPLIST, self::add_handler('validate_settings_fields') );
                add_settings_section('js_section', 'Overall Javascript Settings', self::add_handler('render_options_section_js'), self::UUvID);
                add_settings_section('php_section', 'Overall PHP Settings', self::add_handler('render_options_section_php'), self::UUvID);
        }

        /**
         *
         * Render the plugin options page including important form fields for security
         *
         */
        function render_options_page()
        {
                if( !current_user_can('manage_options') )
                        wp_die( __('You do not have sufficient permissions to access this page.') );
                ?>
          <div class="wrap">
            <h2>Vimeo SEO Playlist</h2>
            <div id="tabs" style="width:85%; padding:10px">
            <ul>
                <li><a href="#tabs-1">Settings</a></li>
                <li><a href="#tabs-2">Shortcodes &amp; readme</a></li>
            </ul>
                <div id="tabs-2" class="wrap yadmin">
                    <div class="icon32" id="icon-options-general"></div>
                    <a href="http://codecanyon.net/item/youtube-seo-playlist-for-wordpress/237365?ref=ceasar" target="_blank"><img align="right" src="<?php echo WP_PLUGIN_URL . '/vimeoplaylist/thumb.jpg'; ?>" width="80" height="80" alt="vimeoplaylist" /></a>
                    <h2>Vimeo Playlist SEO Options</h2><br /><br /><br />
                    <div class="postbox">
                    <b>Default setting:</b> <br />
                        <p>[vimeolist username="wayman"]</p>
                    </div>
                    <div class="postbox">
                    <b>feed type:</b> <br />
                    <p>Available videos , likes , appears_in , all_videos , subscriptions, album, channel or group. Default is videos</p>
                        <p>example: [vimeolist username="wayman" type="videos"] or [vimeolist username="hd" type="channel"] or [vimeolist username="2053056" type="album"]</p>
                    </div>
                    <div class="postbox">
                    <b>All shortcodes:</b>
                        <p><br />Overrule the default playerwidth on every page (including title length, description length, playlistheight, color, slideshow, playlist to the right and other settings)
                        <br /><br />colorbg (#ff0000) , loop (1,0), byline (1,0), title (1,0), centerPlayer (1,0), portrait (1,0)</p>
                        <p><b>Example</b><br /><br /> [vimeolist username="wayman" type="videos" titlelength="60" desclength="150" slideshow="1" playlistheight="2" playerwidth="400" thumb_right="1" color="#000000" loop="1" centerPlayer="1"]</p>
                    </div>
                    <div>
                    <b>NB.</b>
                    <ul>
                    <li>You can only <b>use one player</b> on each page or post !</li>
                    <li>Retrieve max 20 video's. (restriction vimeo)</li>
                    <li>If you want to use the <b>cache option</b> make sure the dir vimeoplaylist - cache has rights to write to (CHMOD)</li>
                    </ul>
                    </div>
                </div><!--#tabs-2-->

                <div id="tabs-1" class="wrap yadmin"><!--#tabs-1-->
                    <div class="icon32" id="icon-options-general"></div>
                        <a href="http://codecanyon.net/item/youtube-seo-playlist-for-wordpress/237365?ref=ceasar" target="_blank"><img align="right" src="<?php echo WP_PLUGIN_URL . '/vimeoplaylist/thumb.jpg'; ?>" width="80" height="80" alt="youtubeplaylist" /></a>
                        <h2>Vimeo Playlist SEO Options</h2>
                        <form method="post" action="options.php">
                        <?php settings_fields(self::VIPLIST); //outputs all hidden fields for security ?>
                            <?php do_settings_sections(self::UUvID); // renders all the html elements for settings ?>
                        <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
                        </form>
                </div><!--#tabs-1-->
            </div>
          </div>
        <?php
        }

        /**
         *
         * Render all the php options by getting all the plugin options from the wp_options table
         * and looping through the "php" subarray
         *
         */
        function render_options_section_php()
        {
                $options = get_option( self::VIPLIST );
                ?>
                <table class="form-table">
                <?php
                        foreach( $options['php'] as $key => $value )
                        {
                                self::render_option_field($key,$value,'php',self::$plugin_settings['php'][$key]);
                        }
                ?>
                </table>
                <?php
        }

        /**
         *
         * Render all the js options by getting all the plugin options from the wp_options table
         * and looping through the "js" subarray
         *
         */
        function render_options_section_js()
        {
                $options = get_option( self::VIPLIST );
                ?>
                <table class="form-table">
                <?php
                        foreach( $options['js'] as $key => $value )
                        {
                                self::render_option_field($key,$value,'js',self::$plugin_settings['js'][$key]);
                        }
                ?>
                </table>
                <?php
        }

        /**
         *
         * Renders a valid html form field for changing plugin options.
         *
         * It checks for the presence of a ["values"] value in the static self::$plugin_settings array
         * - if it is present and it is an array then render a html <select> form field
         * - otherwise render a <input type="text" /> form field.
         *
         */
        function render_option_field($key,$value,$realm,$settings)
        {
                ?>
                <tr valign="top">
                        <th scope="row"><?php echo $settings["name"]; ?></th>
                        <td><?php
                                if( !empty($settings["values"]) && is_array($settings["values"]) ): ?>
                                <select id="<?php echo $key; ?>" name="<?php echo sprintf('%s[%s][%s]',self::VIPLIST,$realm,$key); ?>">
                                        <?php foreach( $settings["values"] as $val ): ?>
                                                <option value="<?php echo $val; ?>"<?php echo ($val==$value) ? " SELECTED" : "";?>><?php echo self::boolToString($val); ?></option>
                                        <?php endforeach; ?>
                                </select>
                                <?php
                                else:
                                        echo sprintf('<input id="%s" name="%s[%s][%s]" type="text" value="%s" />',$key,self::VIPLIST,$realm,$key,$value);
                                endif; ?>
                                <span class="description"><?php echo $settings["desc"]; ?></span>
                        </td>
                </tr>
                <?php
        }

        /**
         *
         * After the plugin options form is submitted validate all form data and convert
         * strings to booleans if needed.
         *
         */
        function validate_settings_fields($input)
        {
                foreach( $input['js'] as $key => $value )
                {
                        if( is_bool(self::$plugin_settings["js"][$key]["default"]) === true )
                        {
                                $input["js"][$key] = (bool)$input["js"][$key];
                        }
                }

                foreach( $input['php'] as $key => $value )
                {
                        if( is_bool(self::$plugin_settings["php"][$key]["default"]) === true )
                        {
                                $input["php"][$key] = (bool)$input["php"][$key];
                        }
                }

                return $input;
        }

        function boolToString($bool)
        {
                if( $bool === true )
                        return "true";
                elseif( $bool === false )
                        return "false";
                else
                        return $bool;
        }

        function add_handler($name)
        {
                return array(__CLASS__,$name);
        }
}
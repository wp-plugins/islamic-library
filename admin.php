<?php
/**
 * @package Islamic Library
 * @version 1.0
 */
/*
 Plugin Name: Islamic Library
 Plugin URI: http://www.islamhouse.com
 Description: Islamic Library plugin contains books, articles, fatwa, videos, quran, poster, cards, programs, favorites, news, apps, MP3, download, and torrent in more than 130 languages
 Version: 1.0
 Author: IslamHouse.com
 Author URI: http://www.islamhouse.com
 License: It is Free -_-
*/
include('function.php');

function islamic_library_plugin_install(){
    add_option( 'islamic_library_language_code', 'en', '', 'yes' ); 
    add_option( 'islamic_library_video_view', 'on', '', 'yes' ); 
    add_option( 'islamic_library_view_breadcrumb', 'on', '', 'yes' ); 
}
register_activation_hook(__FILE__,'islamic_library_plugin_install'); 

function islamic_library_plugin_styles() {
	wp_register_style( 'islamic_library_styles', plugin_dir_url( __FILE__ ).'style.css' );
	wp_enqueue_style( 'islamic_library_styles' );
}
add_action( 'wp_enqueue_scripts', 'islamic_library_plugin_styles' );

function islamic_library_adminHeader() {
	echo "<style type=\"text/css\" media=\"screen\">\n";
	echo "#islamic_library { margin:0 0 20px 0; text-align:center; border:1px solid #cccccc; padding:5px; background-color:#f2f2f2; }\n";
	echo "#islamic_library .lang { padding:5px 0 5px 0; margin:5px 0 10px 0; }\n";
	echo "#islamic_library_content { margin:0 0 0 0; border:1px solid #cccccc; padding:5px; background-color:#fff; }\n";
	echo ".sections { margin:10px 0 10px 0; border:1px solid #cccccc; padding:5px; background-color:#fff; }\n";
	echo ".sections ul { list-style: none; }\n";
	echo ".sections ul li { float: left; padding: 7px; margin:0 5px 5px 5px; width:30%; }\n";
	echo ".sections ul li span { color:green; }\n";
	echo ".sections ul li span.shortcode { color:blue; }\n";
	echo ".sections ul li a { display: block; }\n";
	echo ".sections ul li a img { -webkit-transition: all .3s; -moz-transition: all .3s; -ms-transition: all .3s;	-o-transition: all .3s;	transition: all .3s; }\n";
	do_action('islamic_library_css');
	echo "</style>\n";
}

add_action('admin_head','islamic_library_adminHeader');

function islamic_library_content_replace($text){
$text = preg_replace('/\[section\](.+?)\[\/section\]/e',"islamic_library_json_content('$1')",$text,1); //Find only first match
//$text = preg_replace('/\[section\](.+?)\[\/section\]/e',"islamic_library_json_content('$1')",$text); //Find all matches
return $text;
}
 
add_filter('the_content','islamic_library_content_replace');

add_action( 'admin_menu', 'islamic_library_plugin_menu' );

function islamic_library_plugin_menu() {
	add_menu_page( ''.islamic_library_words('title').'', ''.islamic_library_words('title').'', 'manage_options', 'islamic-library-edit', 'islamic_library_options', ''.trailingslashit(plugins_url(null,__FILE__)).'/icons/menu.png' );
}

function islamic_library_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

if(isset($_POST['submitted']) && $_POST['submitted'] == 1){
if(isset($_POST['islamic_library_video_view'])){ $show_video = 'on'; }else{ $show_video = 'off'; }
if(isset($_POST['islamic_library_view_breadcrumb'])){ $view_breadcrumb = 'on'; }else{ $view_breadcrumb = 'off'; }

	if ( get_option( 'islamic_library_language_code' ) !== false ) {
		update_option( 'islamic_library_language_code', addslashes($_POST['islamic_library_language_code']) );
		update_option( 'islamic_library_video_view', $show_video );
		update_option( 'islamic_library_view_breadcrumb', $view_breadcrumb );
	} else {
		add_option( 'islamic_library_language_code', 'en', null );
		add_option( 'islamic_library_video_view', 'on', null );
		add_option( 'islamic_library_view_breadcrumb', 'on', null );
	}
}

if(get_option('islamic_library_video_view') == 'on'){ $islamic_library_video_view = 'checked="checked"'; }else{ $islamic_library_video_view = ''; }
if(get_option('islamic_library_view_breadcrumb') == 'on'){ $islamic_library_view_breadcrumb = 'checked="checked"'; }else{ $islamic_library_view_breadcrumb = ''; }

?>
	<div id="islamic_library_content" class="submit">
			<div class="dbx-content">				
				<h2><?php echo islamic_library_words('title'); ?></h2>
				<br />
				<form name="sytform" action="" method="post">
					<input type="hidden" name="submitted" value="1" />
					<h3><?php echo islamic_library_words('select'); ?></h3>
					<div>
							<label for="islamic_library_language_code"><?php echo islamic_library_words('Languages'); ?></label>
							<?php echo islamic_library_language_code(); ?>
					</div>

					<h3><?php echo islamic_library_words('options'); ?></h3>
						
					<div>
						<input id="show_video" type="checkbox" name="islamic_library_video_view" <?php echo $islamic_library_video_view; ?> />
						<label for="show_video"><?php echo islamic_library_words('video_view'); ?></label>
					</div>
					
					<div>
						<input id="islamic_library_view_breadcrumb" type="checkbox" name="islamic_library_view_breadcrumb" <?php echo $islamic_library_view_breadcrumb; ?> />
						<label for="islamic_library_view_breadcrumb"><?php echo islamic_library_words('view_breadcrumb'); ?></label>
					</div>
					
					<div style="padding: 1.5em 0;margin: 5px 0;">
						<input type="submit" name="Submit" value="<?php echo islamic_library_words('update_options'); ?>" />
					</div>
				</form>
			</div>   
		</div>
<?php
echo islamic_library_get_language_section();
}

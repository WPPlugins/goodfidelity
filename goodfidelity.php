<?php
/*
Plugin Name: GoodFidelity Bar Music Video YouTube
Version: 2.5.0
Plugin URI: http://www.goodfidelity.com
Author: David Lozano Medina
Author URI: http://www.goodfidelity.com
Description: Complements your website with a administrator of videos and music. Your users will be able to create one or more playlist, you be able to listen music without interruption, may share in facebook and more. Millions of music videos at your fingertips. It offers a powerful search engine. Demo: www.goodfidelity.com. You can also use the short code: [good myvideo="IDyoutube"] - example: [good myvideo="k4l3PAKdQCo"] - [yougood myplaylist="IDPlaylistyoutube"] - example: [yougood myplaylist="PLFgquLnL59alCl_2TQvOiD5Vgm1hCaGSI"] - to create content in your posts. Share button: facebook, google + and twitter.
*/

//GOODFIDELITY

function createtablegood()
{
    global $wpdb;
    $table_name1 = "wp_GOODListas";
 
    $sql[] = "CREATE TABLE $table_name1(
        fecha timestamp NOT NULL default current_timestamp,
		IDusuario bigint(25) NOT NULL default '0',
        nombrelistas varchar(500) NOT NULL default '',
        PRIMARY KEY (`fecha`)
        );";
	
	$table_name2 = "wp_GOODCanciones";
 
    $sql[] = "CREATE TABLE $table_name2(
        fecha timestamp NOT NULL default current_timestamp,
		IDusuario bigint(25) NOT NULL default '0',
        nombrelistas varchar(500) NOT NULL default '',
		IDcancion varchar(50) NOT NULL default '',
		nombrecanciones varchar(500) NOT NULL default '',
        PRIMARY KEY (`fecha`)
        );";
 
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
	
	//Opciones para el panel de admin
	add_option('web_app_login', 'Register to create your playlists');
	add_option('web_app_search', 'Search songs...');	
  	add_option('web_app_list', 'Name of your playlist here...');
	add_option('web_app_nothing', 'You have no playlists');
	add_option('web_app_song', 'You have no songs in this playlist');
	add_option('web_app_playlist', 'checked');
	add_option('web_app_autoplay', 'checked');
	add_option('web_app_idyoutube', 'PLFgquLnL59alCl_2TQvOiD5Vgm1hCaGSI');
	add_option('web_app_playall','Play all');
	add_option('web_app_button_share','checked');
}
register_activation_hook(__FILE__,'createtablegood');

///Panel de admin
function admin_init_goodfidelity() {
  register_setting('optgoodfidelity', 'web_app_login');	
  register_setting('optgoodfidelity', 'web_app_search');
  register_setting('optgoodfidelity', 'web_app_list');
  register_setting('optgoodfidelity', 'web_app_nothing');
  register_setting('optgoodfidelity', 'web_app_song');
  register_setting('optgoodfidelity', 'web_app_playlist');
  register_setting('optgoodfidelity', 'web_app_autoplay');
  register_setting('optgoodfidelity', 'web_app_idyoutube');
  register_setting('optgoodfidelity', 'web_app_playall');
  register_setting('optgoodfidelity', 'web_app_button_share');
}
function admin_menu_goodfidelity() {
  add_menu_page('GoodFidelity', 'GoodFidelity', 8, 'optgoodfidelity', 'options_page_goodfidelity', WP_PLUGIN_URL.'/goodfidelity/images/icon.png');
}

function options_page_goodfidelity() {
  include(WP_PLUGIN_DIR.'/goodfidelity/inc/options.php');  
}

if (is_admin()) {
  add_action('admin_init', 'admin_init_goodfidelity');
  add_action('admin_menu', 'admin_menu_goodfidelity');
}
///Fin de panel de admin

function goodfidelity(){
	//Se recoge datos de button share
	$web_app_button_share = get_option('web_app_button_share');
	echo '<script>share_url= "'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'";</script>';
	if($web_app_button_share != ""){
		?>
		<style>
			div#sharetwitter, div#sharegoogle, div#shareface{
				display:block;
			}
		</style>
		<?php
	} else {
		?>
		<style>
			div#sharetwitter, div#sharegoogle, div#shareface{
				display:none;
			}
		</style>
		<?php
	}
	//Se recoge datos para playlist autoplay
	$web_app_playlist = get_option('web_app_playlist');
	$web_app_autoplay = get_option('web_app_autoplay');
	$web_app_idyoutube = get_option('web_app_idyoutube');
	
	//datos de panel de admin
	$web_app_search = get_option('web_app_search');
    //fin de datos
	global $wpdb;
	global $current_user;
	get_currentuserinfo();
	echo '<script>idusu = '.$current_user->ID.'; pluginurl = "'.WP_PLUGIN_URL.'"; panelsearch = "'.$web_app_search.'"; newplaylist ="'.$web_app_playlist.'"; newautoplay ="'.$web_app_autoplay.'"; newidyoutube ="'.$web_app_idyoutube.'";</script>';	
	if ( !is_admin() ) {
    //LLama a styles
	wp_register_style( 'myrender', plugins_url('/css/render.css', __FILE__) );
	wp_enqueue_style( 'myrender' );
	wp_register_style( 'myscroll', plugins_url('/css/jquery.mCustomScrollbar.css', __FILE__) );
	wp_enqueue_style( 'myscroll' );
	wp_register_style( 'mypagegood', plugins_url('/css/page.css', __FILE__) );
	wp_enqueue_style( 'mypagegood' );
	//Llama a .js local
	wp_register_script( 'myscriptscroll', plugins_url('/js/jquery.mCustomScrollbar.concat.min.js', __FILE__), array('jquery') );
	wp_enqueue_script('myscriptscroll');
	wp_register_script( 'myrender', plugins_url('/js/render.min.js', __FILE__), array('jquery', 'jquery-effects-fade') );
	wp_enqueue_script('myrender');
	}
}    
add_action('wp_footer', 'goodfidelity');

//AJAX//
require ("ext/related-song.php");
require ("ext/related-analista.php");
require ("ext/related-list.php");
require ("ext/related-playlist.php");
require ("ext/related-good.php");
require ("ext/related-youlist.php");
?>
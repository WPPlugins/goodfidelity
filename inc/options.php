<div class="wrap">
<h2>GoodFidelity</h2>
<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>
<?php settings_fields('optgoodfidelity'); ?>
	<label><strong>Text login : </strong></label><br />
    <input type="text" name="web_app_login" value="<?php echo get_option('web_app_login'); ?>" size="35" /><br /><br />
    <label><strong>Text search : </strong></label><br />
    <input type="text" name="web_app_search" value="<?php echo get_option('web_app_search'); ?>" size="35" /><br /><br />
    <label><strong>Text playlists : </strong></label><br />
    <input type="text" name="web_app_list" value="<?php echo get_option('web_app_list'); ?>" size="35" /><br /><br />
    <label><strong>Text no playlists : </strong></label><br />
    <input type="text" name="web_app_nothing" value="<?php echo get_option('web_app_nothing'); ?>" size="45" /><br /><br />
    <label><strong>Text no song in playlist : </strong></label><br />
    <input type="text" name="web_app_song" value="<?php echo get_option('web_app_song'); ?>" size="45" /><br /><br /><br />

	<h3>Playlist</h3>    
    
    <input type="checkbox" name="web_app_playlist" value="Share" <?php if (get_option('web_app_playlist') != "") echo checked; ?> /><strong>Playlist</strong>
    <input type="checkbox" name="web_app_autoplay" value="Share" <?php if (get_option('web_app_autoplay') != "") echo checked; ?> /><strong>Autoplay</strong>
    <br /><br />
    <label><strong>ID playlist YouTube : </strong></label><br />
    <input type="text" name="web_app_idyoutube" value="<?php echo get_option('web_app_idyoutube'); ?>" size="45" /><br /><br />
    
    <h3>Button share</h3>
    
    <input type="checkbox" name="web_app_button_share" value="Share" <?php if (get_option('web_app_button_share') != "") echo checked; ?> /><strong>Button share</strong>
    
    <h3>Shortcode</h3>
    <label><strong>Text play all : </strong></label><br />
    <input type="text" name="web_app_playall" value="<?php echo get_option('web_app_playall'); ?>" size="45" /><br /><br />
    
    <input type="hidden" name="action" value="update" />
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</form>
<p><strong>Paste in post or page:</strong></p>
<p>[good myvideo="IDyoutube"] - example: [good myvideo="k4l3PAKdQCo"]</p>
<p>[yougood myplaylist="IDPlaylistyoutube"] - example: [yougood myplaylist="PLFgquLnL59alCl_2TQvOiD5Vgm1hCaGSI"]</p>

</div>
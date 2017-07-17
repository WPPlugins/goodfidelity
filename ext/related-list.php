<?php
function mi_funcion_list_ajax(){
//datos de panel de admin	  
$web_app_login = get_option('web_app_login');
$web_app_list = get_option('web_app_list');
//fin de datos
global $current_user;
get_currentuserinfo();
$IDusu = $current_user->ID;

if ($IDusu == 0){
?>
	<a href="#!" onclick="javascript:cerrartodo()"><div id="logingood"><?php echo $web_app_login ?></div></a>
<?php
} else {
?>
		<div id="playlistdiv"></div>
        <form method="post" action="/wp-admin/admin-ajax.php?action=mi_funcion_playlist" id="crearplaylist" name="crearplaylist1" >
            <input class="textocreador" type="text" name="crearplaylist" placeholder="<?php echo $web_app_list ?>" onfocus="if(this.placeholder=='<?php echo $web_app_list ?>')this.placeholder=''" onblur="if(this.placeholder=='')this.placeholder='<?php echo $web_app_list ?>'" autocomplete="off"/>
            <input class="botoncreador" type="submit" name="submit" value=""/>
        </form>
<?php
}
?>
<script>
abrirplaylists();

///  Crear un playlist y muestra el resultado del evento en playlistevento 
(function($){$(document).ready(function() {
   // Interceptamos el evento submit para buscar canciones
    $('#form, #crearplaylist').submit(function() {
	//Abre el gif loading
	
  // Enviamos el formulario usando AJAX buscar
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
			// Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
				///Cierra el gif loading OJO.- poner antes que $("#panel-playlist-corto").html(data);
				$('#playlistdiv').html(data);
				
            }
        })        
        return false;
    });
});})(jQuery);

</script>
<?php
die();
}
add_action( 'wp_ajax_nopriv_mi_funcion_list', 'mi_funcion_list_ajax' );  
add_action( 'wp_ajax_mi_funcion_list', 'mi_funcion_list_ajax' );
?>
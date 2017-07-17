<?php
function mi_funcion_analista_ajax(){
//datos de panel de admin	  
$web_app_login = get_option('web_app_login');
$web_app_nothing = get_option('web_app_nothing');
//fin de datos
global $wpdb;
global $current_user;
get_currentuserinfo();

$IDusu = $current_user->ID;
$TITLEtube = $_POST["variable_titulo"];
$IDtube = $_POST["variable_id"];
	
if ($IDusu == 0){ ?>
	<a href="#!" class="closeall" onclick="javascript:cerrartodo()"><div id="logingood"><?php echo $web_app_login ?></div></a>
<?php }
else{

		///Abre los playlists en cualquier caso	
			$abrirplaylist = $wpdb->get_results("SELECT * FROM wp_GOODListas WHERE IDusuario = '$IDusu' ORDER BY nombrelistas ASC");
			if ($abrirplaylist[0]->IDusuario!=""){
				foreach($abrirplaylist as $playlistabrir){
					$nombre = $playlistabrir->nombrelistas; ?>
					<div id="playlistasusu">
                		<a href="#!" class="desaparece" onClick="javascript:anafinal('<?php echo $nombre ?>','<?php echo $IDtube ?>','<?php echo $TITLEtube ?>')"><div id="playlistastitle"><?php echo $nombre ?></div><div id="playlistasmas"></div></a>
                	</div> <?php
				}		
			}
			
			else{ ?>
				<div id="nothing"><a href="#!" class="desaparecelist"><?php echo $web_app_nothing; ?></a></div>
			<?php }
}
?>

<script>
(function($){$('.desaparece').click(function(){
   $('#divanalista').toggle('fade',1500); 
});})(jQuery);

(function($){$('.desaparecelist').click(function(){
   $('#divanalista').toggle('fade',1500);
   document.getElementById('playlist').style.display = 'block';
}); })(jQuery);
</script>

	<script>
		(function($){
				$("#listaanausuario").mCustomScrollbar({
					autoHideScrollbar:true,
					theme:"dark-2",
					scrollButtons:{
						enable:false
					}
				});
		})(jQuery);
	</script>
<?php
die();
}
add_action( 'wp_ajax_nopriv_mi_funcion_analista', 'mi_funcion_analista_ajax' );  
add_action( 'wp_ajax_mi_funcion_analista', 'mi_funcion_analista_ajax' );
?>
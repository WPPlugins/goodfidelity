<?php
function mi_funcion_playlist_ajax(){  
//datos de panel de admin	  
$web_app_nothing = get_option('web_app_nothing');
//fin de datos
global $wpdb;
global $current_user;
get_currentuserinfo();

$IDusu = $current_user->ID;
$crearplaylist = $_POST['crearplaylist'];
$borrarplaylistsi = $_POST['borrarplaylistsi'];
		
		///Borra un playlists
		if($borrarplaylistsi != ""){
			
			$wpdb->query( "DELETE FROM wp_GOODListas WHERE IDusuario = '$IDusu' AND nombrelistas = '$borrarplaylistsi'" );
			$wpdb->query( "DELETE FROM wp_GOODCanciones WHERE IDusuario = '$IDusu' AND nombrelistas = '$borrarplaylistsi'" );
			
		}
		///Crea el playlist verificando si hay duplicados 
		if ($crearplaylist==""){ }
		else {
			$buscarsihay = $wpdb->get_results("SELECT * FROM wp_GOODListas WHERE IDusuario = '$IDusu' AND nombrelistas = '$crearplaylist'");
			if ($buscarsihay[0]->IDusuario!="" and $buscarsihay[0]->nombrelistas!=""){ }
			else {
				$wpdb->insert( 'wp_GOODListas', array( 'IDusuario' => $IDusu, 'nombrelistas' => $crearplaylist ) );
			}
		}
		///Abre los playlists en cualquier caso	
			$abrirplaylist = $wpdb->get_results("SELECT * FROM wp_GOODListas WHERE IDusuario = '$IDusu' ORDER BY nombrelistas ASC");
			if ($abrirplaylist[0]->IDusuario!=""){
				foreach($abrirplaylist as $playlistabrir){
					$nombre = $playlistabrir->nombrelistas; ?>
					<div id="playlistas">
                		<a href="#!" onClick="javascript:abrircanciones('<?php echo $nombre ?>')"><div id="playlistastitle"><?php echo $nombre ?></div></a>
                		<a href="#!" onClick="javascript:abrirconfirmar('<?php echo $nombre ?>')"><div id="playlistasdelet"></div></a>
    				</div> <?php
				}		
			}
			else{ ?>
				<div id="nothing"><?php echo $web_app_nothing ?></div>
                <script>
					var frameplaylist = parent.document.getElementById("popupcrearplay");
					frameplaylist.style.display="block";
				</script>
			<?php }

 ?>
		<script>
		(function($){
				$("#playlistdiv").mCustomScrollbar({
					autoHideScrollbar:true,
					theme:"dark-2",
					scrollButtons:{
						enable:false
					}
				});
		})(jQuery);
		document.crearplaylist1.reset();
		document.crearplaylist2.reset();
		document.crearplaylist3.reset();
		</script> 
<?php
die();
}   
add_action( 'wp_ajax_nopriv_mi_funcion_playlist', 'mi_funcion_playlist_ajax' );  
add_action( 'wp_ajax_mi_funcion_playlist', 'mi_funcion_playlist_ajax' );
?>
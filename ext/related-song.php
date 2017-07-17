<?php
function mi_funcion_song_ajax(){
//datos de panel de admin	  
$web_app_song = get_option('web_app_song');
//fin de datos

global $wpdb;
global $current_user;
get_currentuserinfo();

$IDusu = $current_user->ID;
$crearplaylist = $_POST['variable_name'];
$IDtube = $_POST['variable_id'];
$TITLEtube = $_POST['variable_titulo'];
//Borra una canción del playlist
if($IDusu != "" and $crearplaylist != "" and $IDtube != "" and $TITLEtube == ""){
	$wpdb->query("DELETE FROM wp_GOODCanciones WHERE IDusuario = '$IDusu' AND nombrelistas = '$crearplaylist' AND IDcancion = '$IDtube' ");	
}
//Añade una canción al playlist
if($IDusu != "" and $crearplaylist != "" and $IDtube != "" and $TITLEtube != ""){
	$buscarsihay = $wpdb->get_results("SELECT * FROM wp_GOODCanciones WHERE IDusuario = '$IDusu' AND nombrelistas = '$crearplaylist' AND IDcancion = '$IDtube'");	
	if ($buscarsihay[0]->IDusuario!="" and $buscarsihay[0]->nombrelistas!="" and $buscarsihay[0]->IDcancion!=""){ }
	else {
		$wpdb->insert( 'wp_GOODCanciones', array( 'IDusuario' => $IDusu, 'nombrelistas' => $crearplaylist, 'IDcancion' => $IDtube, 'nombrecanciones' => $TITLEtube ) ); 
	}
}
?>
<a href="#!" onclick="javascript:playlistall()"><div id="playtodo"></div></a>
<a href="#!" onclick="javascript:abrirlistacookie()"><div id="cerrarplayfooter"></div></a>
<div id="horizontal">
<?php
///Abre las canciones	
			$abrirplaylist = $wpdb->get_results("SELECT * FROM wp_GOODCanciones WHERE IDusuario = '$IDusu' AND nombrelistas = '$crearplaylist' ORDER BY fecha DESC");
			if ($abrirplaylist[0]->IDusuario!="" and $abrirplaylist[0]->nombrelistas!=""){
				foreach($abrirplaylist as $playlistabrir){
							
			    $IDcancion = $playlistabrir->IDcancion;
        		$TITLEcancion = $playlistabrir->nombrecanciones;
				
				$url_actual = "http://www.goodfidelity.com/goodfidelity/?ID=".$IDcancion;
				?>
                
                
				<div id="videos_artista_lista">
    				<a href="http://youtube.com/embed/<?php echo $IDcancion; ?>?autoplay=1" target="reprotube" title="Play" onclick="javascript:listaderecha()">
                    <div id="videos_imagen_lista">
        				<img src="http://i.ytimg.com/vi/<?php echo $IDcancion ?>/1.jpg" height="90px" width="120px" alt="<?php echo $TITLEcancion ?>">
        			</div>
        			<div id="playvideoimagesong">
            		</div>
                    </a>
                    <a href="#!" class="showdivsin" onclick="javascript:abrirsingular('<?php echo $IDcancion ?>','<?php echo $TITLEcancion ?>')" >
                    	<div id ="videos_title_lista">
        					<?php echo $TITLEcancion ?>
        				</div>
                    </a>
                    <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo $url_actual; ?>','facebook-share-dialog','width=626,height=436'); popupverificarabrir('<?php echo $IDcancion; ?>'); return false;" title="Facebook"><div id="botonfacebooklista"></div></a>
                    <a href="#!" class="showdivlista" onClick="javascript:anadircancion('<?php echo $IDcancion ?>','<?php echo $TITLEcancion ?>')"><div id="maslist"></div></a>
                    <a href="#!" onClick="javascript:borrarcancionlist('<?php echo $crearplaylist ?>','<?php echo $IDcancion ?>')"><div id="delete_song"></div></a>
    			</div>
            	<?php
				//Crea el cookie playlist para la reproducción de todos los videos simultáneamente
						$X = $X + 1;
						if ($X == 1) {
							$primero = $IDcancion;
						} 
						if ($X > 1) {
							$playtube = $playtube.",".$IDcancion;	
						}
            	}
			}
			else{ ?>
				<div id="nothing" style="color:#FFF"><?php echo $web_app_song ?></div>
			<?php }
?>
</div>
<script>
(function($){$('.showdivlista').on('click', function(){
	$('#divanalista').show( "fast" );
});})(jQuery);
</script>
<?php $agente = $_SERVER['HTTP_USER_AGENT'];
if (stripos($agente,"Tablet") == "" and stripos($agente,"Mobile") == ""){ ?>
<style>
/*SONG*/
div#horizontal {
	float:left;
	width:100%;
	margin-top:5px;
	background:#000;
}
div#horizontalyou{
	float:left;
	width:100%;
	margin-top:0px;
	background:#000;
	line-height:12px;
	padding-top:10px;
}
.interior{
	padding:0px 10px 0 10px !important;
}
div#videos_artista_lista{
	float:left;
	margin-left:5px;
}
</style>
<script>
(function($){$('.showdivsin').on('click', function(){
	$('#barsearch').show( "fast" );
	$('#bodysearch').show( "fast" );
});})(jQuery);
</script>
<!-- custom scrollbars plugin -->
	<script>
		(function($){
				$("#horizontal").mCustomScrollbar({
					horizontalScroll:true,
				});
	
		})(jQuery);
	</script>
<?php }  else { ?>
<style>
div#horizontal{
	float:left;
	width:100%;
	margin-top:10px;
	overflow-x:scroll;
	overflow-y:hidden;
	height:120px;
	white-space:nowrap;
	background:#000;
}
div#horizontalyou{
	float:left;
	width:100%;
	margin-top:0px;
	overflow-x:scroll;
	overflow-y:hidden;
	height:120px;
	white-space:nowrap;
	background:#000;
	line-height:12px;
}
.interior{
	padding:10px 10px 0 10px !important;
}
div#videos_artista_lista{
	display:inline-block;
	margin-left:7px;
}
</style><script>
(function($){$('.showdivsin').on('click', function(){
	$('#barsearch').show( "fast" );
	$('#bodysearch').show( "fast" );
	listaizquierda();
});})(jQuery);
</script>
<?php } ?>
<?php if ($primero != "" and $playtube != "") {?>
<script>
///Reproduce todas las canciones de la cola, se ejecuta desde cookie.php
function playlistall(){
	window.frames.reprotube.location.href = 'http://www.youtube.com/embed/<?php echo $primero ?>?playlist=<?php echo $playtube ?>&autoplay=1';
	listaderecha();
}
</script>
<?php }


die();
}
add_action( 'wp_ajax_nopriv_mi_funcion_song', 'mi_funcion_song_ajax' );  
add_action( 'wp_ajax_mi_funcion_song', 'mi_funcion_song_ajax' );
?>
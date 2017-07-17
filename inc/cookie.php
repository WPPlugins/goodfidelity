<?php
error_reporting(0);
//Recupera la variable inicial
$varpto = $_POST['newvar_varpto'];
if ($varpto == "") {$varpto = 2;}
//Recupera la variable para playlist
$IDtube = $_POST['varia_idtube'];
$TITLEtube = $_POST['varia_idtitle'];
//datos de playlist
$newplaylist = $_POST['var_newplaylist'];
$newautoplay = $_POST['var_newautoplay'];
$newidyoutube = $_POST['var_newidyoutube'];
//Añade una canción al array
if ($IDtube != "" and $TITLEtube != ""){
setcookie("IDCookie[".$IDtube."]", $TITLEtube, time()+3600*24*30*12);
?>
<script>recargar();</script>
<?php
}
if ($_COOKIE["IDCookie"] == ""){} else {
	$c = array_reverse($_COOKIE["IDCookie"]);
}
//Quita una canción del array
if ($IDtube != "" and $TITLEtube == ""){
setcookie ("IDCookie[".$IDtube."]", "", time() - 3600);
?>
<script>recargar();</script>
<?php
}
?>
<a href="#!" onclick="javascript:playlistall()"><div id="playtodo"></div></a>
<?php
//Se coloca el playlist en la primera visita del usuario
if ($c == ""){
	if($newplaylist != ""){
	$data = file_get_contents("https://www.youtube.com/playlist?list=".$newidyoutube."");
	?>
<div id="horizontal">
<?php
	for ($Y = 0; $Y <= 19; $Y++){
		
		///Recupera el título del video
		preg_match_all("(data-title=\"(.*)\")siU", $data, $title_mat);
		///Recupera el ID del video
		preg_match_all("(data-video-id=\"(.*)\")siU", $data, $id_mat);
		
		$TITLEcancion = $title_mat[1][$Y];
		$TITLEcancion = str_replace("'","",$TITLEcancion);
		$TITLEcancion = str_replace("#","",$TITLEcancion);
		$TITLEcancion = str_replace('"','',$TITLEcancion);
		
		$IDcancion = $id_mat[1][$Y];
		
		$url_actual = "http://www.goodfidelity.com/goodfidelity/?ID=".$IDcancion;
		if($IDcancion == ""){}else{
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
?>
 </div>  
<?php
	}
}
else{
?>
<div id="horizontal">
<?php
if (isset($c)) {
    foreach ($c as $IDcancion => $TITLEcancion) {
        $IDcancion = htmlspecialchars($IDcancion);
        $TITLEcancion = htmlspecialchars($TITLEcancion);
		
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
                    <a href="#!" onClick="javascript:borrarcancion('<?php echo $IDcancion ?>')"><div id="delete_song"></div></a>
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

?>
</div>
<?php } ?>
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
		var varpto = <?php echo $varpto ?>;
		(function($){
				if ( varpto == 1 ) {
					$("#horizontal").mCustomScrollbar({
						horizontalScroll:true,
					});
				
					$(".interior").mCustomScrollbar({
						horizontalScroll:true,
					});
				}
				if ( varpto == 2 ) {
					$("#horizontal").mCustomScrollbar({
						horizontalScroll:true,
					});
				};
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
</style>
<script>
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
	window.frames.reprotube.location.href = 'http://www.youtube.com/embed/<?php echo $primero ?>?playlist=<?php echo $playtube ?>&autoplay=1&wmode=transparent';
	listaderecha();
}
</script>
<?php } ?>
<?php
if ($c == ""){ 
	if ($newautoplay != "" and $IDtube == "") { ?>
	<script>playlistall(); listaarriba();</script>
	<?php
	}
}
?>

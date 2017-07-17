<?php
function playlistautomatic($atts){
	//Recoje datos de playall
	$web_app_playall = get_option('web_app_playall');	
	
		$atributesyou = shortcode_atts(array(
			'myplaylist' => 'Falta el ID'
			), $atts);
		$IDtubeyou = $atributesyou['myplaylist'];
			
		$data = file_get_contents("https://www.youtube.com/playlist?list=".$IDtubeyou."");
?>
<div id="envuelvetodo">
<div id="bodypage">
       	<a href="#!" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>','facebook-share-dialog','width=626,height=436'); popupverificarabrir('<?php echo $IDcancion; ?>'); return false;" title="Facebook"><div id="botonface"></div></a>
		<a href="#!" onclick="javascript:playlistallyou()"><div id="botonejecall"><div id="botonplay1"></div><div id="playallyou"><?php echo $web_app_playall ?></div></div></a>
</div>
<div id="horizontalyou">
<div class="interior">
<?php
	for ($Y = 0; $Y <= 49; $Y++){
		
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
		
		if ($IDcancion != ""){
		?>
        
			<div id="videos_artista_lista">
    				<a href="http://youtube.com/embed/<?php echo $IDcancion; ?>?autoplay=1" target="reprotube" title="Play" onclick="javascript:abrirlista('<?php echo $IDcancion ?>','<?php echo $TITLEcancion ?>')">
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
							$primeroyou = $IDcancion;
						} 
						if ($X > 1) {
							$playtubeyou = $playtubeyou.",".$IDcancion;
						}
		}
	}
?>
</div>
</div>
<div id="bodypage">
       	<a href="#!" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>','facebook-share-dialog','width=626,height=436'); popupverificarabrir('<?php echo $IDcancion; ?>'); return false;" title="Facebook"><div id="botonface"></div></a>
		<a href="#!" onclick="javascript:playlistallyou()"><div id="botonejecall"><div id="botonplay1"></div><div id="playallyou"><?php echo $web_app_playall ?></div></div></a>
</div>
</div>
<?php $agente = $_SERVER['HTTP_USER_AGENT'];
if (stripos($agente,"Tablet") == "" and stripos($agente,"Mobile") == ""){ ?>
<!-- custom scrollbars plugin -->
	<script>

		(function($){
				$(".interior").mCustomScrollbar({
					horizontalScroll:true,
				});
		})(jQuery);

	</script> 
<?php } else {} ?>
    
<script>
///Reproduce todas las canciones de la cola, se ejecuta desde cookie.php
function playlistallyou(){
	window.frames.reprotube.location.href = 'http://www.youtube.com/embed/<?php echo $primeroyou ?>?playlist=<?php echo $playtubeyou ?>&autoplay=1';
	listaderecha();
}
</script> 
<?php		
}

function register_shortcodesyou(){
   add_shortcode('yougood', 'playlistautomatic');
}

add_action( 'init', 'register_shortcodesyou');

?>

<div id="contentsearch">
<?php
	$TITLEtube = $_POST["variable_titulo"];
	$IDtube = $_POST["variable_id"];
	
?>	
	<div id="searchtitle">	
		<?php echo $TITLEtube; ?> 
    </div>
<?php	
	///API de YouTube para recuperar los vídeos
	$xml = "http://gdata.youtube.com/feeds/api/videos/".$IDtube."/related?v=2&start-index=1&max-results=50";
	$datos = simplexml_load_file($xml); //lo cargo como archivo xml
	foreach($datos->entry as $video){
		///Recupera el ID del video
		$IDtube = str_replace('tag:youtube.com,2008:video:','',$video->id);
		///Recupera la imagen del video
		$IMAGEtube = "http://i.ytimg.com/vi/".$IDtube."/1.jpg";
		///Recupera el título del video
		$TITLEtube = $video->title;
		$TITLEtube = str_replace("'","",$TITLEtube);
		$TITLEtube = str_replace("#","",$TITLEtube);
		$TITLEtube = str_replace('"','',$TITLEtube);
		///Recupera la descripción del video
		///$DESCRIPTIONtube = $video->children("media",true)->group->description;
		
		$url_actual = "http://www.goodfidelity.com/goodfidelity/?ID=".$IDtube;
?>
		<div id="searchblock">
        	<a href="http://youtube.com/embed/<?php echo $IDtube; ?>?autoplay=1" target="reprotube" title="Play" onclick="javascript:abrirlista('<?php echo $IDtube ?>','<?php echo $TITLEtube ?>')">
            	<div id="searchvideoimage">
            		<img src="<?php echo $IMAGEtube ?>" height="90px" width="120px" alt="Imagen del vídeo <?php echo $TITLEtube ?>">
                </div>
            	<div id="playvideoimage"></div>
            </a>
            <a href="#!" onclick="javascript:abrirsingular('<?php echo $IDtube ?>','<?php echo $TITLEtube ?>')">
            	<div id ="searchvideotitle">
            		<?php echo $TITLEtube ?>
            	</div>
            </a>	
                
                
                <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo $url_actual; ?>','facebook-share-dialog','width=626,height=436'); popupverificarabrir('<?php echo $IDtube; ?>'); return false;" title="Facebook"><div id="botonfacebook"></div></a>
                <a href="#!" class="showdivlista" onClick="javascript:anadircancion('<?php echo $IDtube ?>','<?php echo $TITLEtube ?>')"><div id="maslistmas"></div></a>
        </div>
<?php		
	}
?>
</div>
<div id="searchfooter"></div>
<script>
(function($){$('.showdivlista').on('click', function(){
	$('#divanalista').show( "fast" );
});})(jQuery);
</script>
<?php $agente = $_SERVER['HTTP_USER_AGENT'];
if (stripos($agente,"Tablet") == "" and stripos($agente,"Mobile") == ""){ ?>
<style>
/*SONG*/

</style>
<!-- custom scrollbars plugin -->
	<script>
		(function($){
				$("#bodysearch").mCustomScrollbar({
						autoHideScrollbar:true,
						theme:"dark",
					scrollButtons:{
						enable:false,
					}
				});
		})(jQuery);
	</script>
<?php }  else { ?>
<style>
div#bodysearch{
	overflow-y:scroll;
}
</style>
<?php } ?>
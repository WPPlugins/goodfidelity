<?php
function videorelatedautomatic($atts){
	    $atributes = shortcode_atts(array(
			'myvideo' => 'Falta el ID'
			), $atts);
		$IDtube = $atributes['myvideo'];
		
		$data = file_get_contents("http://www.youtube.com/watch?v=".$IDtube."");
		
		preg_match_all("(<title>(.*)</title>)siU", $data, $matches1);
		$TITLEtube= $matches1[1][0];
		$TITLEtube= str_replace(" - YouTube","",$TITLEtube);
		$TITLEtube= str_replace("&#39;","",$TITLEtube); 
		preg_match_all("(<div id=\"watch-description-text\">(.*)</div>)siU", $data, $matches2);
		$descriptionvideo=preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.#!%-]*(\?\S+)?)?)?)@',"",$matches2[1][0]);
		
		$url_actual = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		
		if ($IDtube == "" or $TITLEtube == ""){}else{
		
        $var = '<div id="bodypage">
       	<a href="#!" class="showdivsin" onclick="javascript:abrirsingular(\''.$IDtube.'\',\''.$TITLEtube.'\')"><div id="searchtitle1">'.$TITLEtube.'</div></a>
        <div id="barrapage">
        <a href="#" onclick="window.open(\'https://www.facebook.com/sharer/sharer.php?u='.$url_actual.'\',\'facebook-share-dialog\',\'width=626,height=436\'); popupverificarabrir(\''.$IDtube.'\'); return false;" title="Facebook"><div id="botonface"></div></a>
		<a href="http://youtube.com/embed/'.$IDtube.'?autoplay=1" target="reprotube" rel="nofollow" title="Play" onclick="javascript:abrirlista(\''.$IDtube.'\',\''.$TITLEtube.'\')"><div id="botonejecall"><div id="botonplay1"></div></div></a>
		<a href="#!" class="showdivlista" onClick="javascript:anadircancion(\''.$IDtube.'\',\''.$TITLEtube.'\')"><div id="maslistmas1"></div></a>
        </div>
        <div id="imageprincipal1">
        	<a href="http://youtube.com/embed/'.$IDtube.'?autoplay=1" target="reprotube" rel="nofollow" title="Play" onclick="javascript:abrirlista(\''.$IDtube.'\',\''.$TITLEtube.'\')"><img src="http://i3.ytimg.com/vi/'.$IDtube.'/hqdefault.jpg" alt="'.$TITLEtube.'" width="100%">
			<div id="playou"></div>
            </a><div id="descprincipal1"><a href="http://www.goodfidelity.com" target="_blank">GoodFidelity</a></div>
            
		</div>
        </div>';
		return $var;
		  
		} 
}

function register_shortcodesrelated(){
   add_shortcode('good', 'videorelatedautomatic');
}

add_action( 'init', 'register_shortcodesrelated');
?>

<?PHP
if (Constants::$V['_GET']) {
	$_GET = Constants::$V['_GET'];
}
$q = @$_GET['q'] ? $_GET['q'] : 'coreDekaron';
$c = @$_GET['c'] > 0 && $_GET['c'] < 10 ? $_GET['c'] : 1;
$t = @$_GET['t'] ? $_GET['q'] : 'player';
$params = array(
				'q' => $q,
				'maxResults' => $c,
				'type'=>'video',
				'order'=>'date'
);
	
	/* how to get channel
	$params = array(					
				'channelId' => 'UCPXC89ZzF0uI8-y27sLbygA',
					'maxResults' => 6,
					'type'=>'video',
					'order'=>'date'
	);*/
$items = ApiController::youtube_get_list($params);
if (count($items) > 0) {
switch ($t) {
	default:
		foreach($items['data'] as $s) {
			$id = $s['id']['videoId'];
			$thmb = $s['snippet']['thumbnails']['medium']['url'];
			$title = $s['snippet']['title'];
			echo '<div class="col-xs-4">';
			echo '<div class="ytThmb">
				<a data-toggle="tooltip" data-placement="bottom"
					title="'.$title.'"
					href="http://www.youtube.com/watch?v='.$id.'" target="_NEW"><img src="'.$thmb.'" /></a></div>';
			//echo '<div class="ytTitle">'.$title.'</div>';
			echo '</div>';
		}
	
	break;
	case 'player':
		$w = !@$_GET['w'] ? 560 : $_GET['w'];
		$h = !@$_GET['h'] ? 315 : $_GET['h'];
		$vid = $items['data'][0];
		$id = $vid['id']['videoId'];
		$channel = $vid['snippet']['channelId'];
		echo '<iframe 
		width="'.$w.'" 
		height="'.$h.'" 
		src="https://www.youtube.com/embed/'.$id.'?list='.$channel.'" 
		frameborder="0" 
		allowfullscreen></iframe>';	
	break;
	
}

} else echo 'failed to load search'; 

?>
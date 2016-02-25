<h2 class="">Vote Rewards. <small class="text-muted">earn points.</small></h2>
<?PHP
//error_reporting(E_ALL);

$web = $game->decodeThis('Website','Settings');
$rewards = $game->decodeDefinesArray('Vote Rewards');
Constants::$V['widgets'] = array();
$game->db->debug=0;
/* get time for next reset */
$script = 'Dekaron-VoteRewards.php';
//print_r($info);

Constants::$V['widgets']['rewards'] = array(
	'col'=>12,
	'display'=>true,
	'title'=>'Rewards Info',
	'icon'=>'fa-bars',
	);
	
//get last winners		
$winners = 'No winners yet';
$rs = $game->db->Execute('select * from tasker_logs where script = ? order by id desc LIMIT 0 , 1',$script);
if ($rs) {
	$wi = $rs->GetArray();
	$winners = $wi[0]['output'];	
	$w2 = explode('<br/>',$winners);
	$winners2 = '<b>WINNER LIST</b><ol class="winnerList">';
	unset($w2[0]);
	$show = 4;
	$cnt = 1;
	//$w2 = array($w2[1],$w2[2],$w2[1],$w2[2],$w2[1],$w2[1],$w2[2]);
	if (count($w2) > 1) {
	foreach($w2 as $ww => $w) {		
		$e = explode(' ',$w);
		if ($cnt == $show) {
			$winners2 .= '<div class="collapse" id="listcollapse">';	
		}
		$winners2 .= '<li><label>'.$cnt.'. '.$e[2].'</label> '.$e[4].' <b class="label label-success">'.$label['cash'].'</b></li>';
	
		$cnt++;
		
	}
	
	$winners2 .= '</div><a data-toggle="collapse" href="#listcollapse" aria-expanded="false" aria-controls="listcollapse">see more winners...</a>';	
	}
	$winners2 .= '</ol>';
}	
//get task information
$body = '<i>Monthly Rewards has been disabled</i>';
$rs = $game->db->Execute('select * from tasker where scriptpath = ?',$script);
$sc = $rs->GetArray();
if (@is_array($sc[0])) {

	$body = '<table class="table table-striped table-1stRow">';
		$next = date($info['Basic']['Date Format'],$sc[0]['time_last_fired']);
		if ($sc[0]['time_last_fired'] > time()) 
			$next = '<i>Still waiting for first event time</i>';
		
	
	$body .= '<tr><td><small>Interval</small></td><td>'. convertToHoursMins2($sc[0]['time_interval'], $format = '%d Days / %d Hours / %d Minutes') .'</td></tr>';
	$body .= '<tr><td rowspan="2"><small>Next Event</small></td><td>'.date($info['Basic']['Date Format'],$sc[0]['fire_time']+$sc[0]['time_interval']) . '</td></tr>';
	$body .= '<tr><td>'. timeDifference(date('Y-m-d H:i:s',time()),$sc[0]['fire_time']) .'</td></tr>';
	
	$body .= '<tr><td><small>Server:</small></td><td><a href="http://beta.core-games.net/dashboard/3/Dekaron/Topvoters">A3 Dekaron</a> / <a href="http://beta.core-games.net/dashboard/2/Dekaron/Topvoters">A9 Dekaron</a></td></tr>';
	
	$body .= '<tr><td><small>Last Event</small></td><td>'.$next . '</td></tr>';
	$body .= '<tr><td><small>Last Winners</small></td><td>'.$winners2.'</td></tr>';
	
	$body .= '</table>';
	Constants::$V['widgets']['rewards']['table'] = $body;
} else {	
	Constants::$V['widgets']['rewards']['body'] = $body;	
}




Constants::$V['widgets']['info']  = array(
	'col'=>12,
	'display'=>true,
	'title'=>'Monthly Awards',
	'icon'=>'fa-bars',
	);
/* table for rewards */
if (count($rewards) == 0) {
	Constants::$V['widgets']['info']['body'] = '<i>Server Rewards has been disabled</i>';
} else {
$imsg = '<table class="table table-striped"><thead><tr><th>Rank</th><th>Rewards</th></tr></thead></tbody>';
foreach($rewards as $rr => $r) {
	$imsg .= '<tr><td><small>#</small><b>'.$rr.'</b></td><td>'.number_format(intval($r)).' <b class="label label-success">'.$label['cash'].'</b></td></tr>';
}
$imsg .= '</tbody></table>';
	Constants::$V['widgets']['info']['table'] = $imsg;
}
/* table for rewards */






//get top voters 
//$game->db->debug=1;
$rs = $game->db->Execute('SELECT DISTINCT userno as NO, max( userid ) as ID , count( * ) VOTES, sum( points ) TOTAL
	, max( timestamp ) LAST
	FROM `front_user_votes`
	GROUP BY userno
	ORDER BY sum( points ) DESC
	LIMIT 0 , 31');

$topVoters = array();
foreach($rs->GetArray() as $rr => $r) {
	$r['NAME'] = $game->getProfile($r['NO']);
	$topVoters[] = $r;
}

//print_r($topVoters);
?>

<div class="topVoters">
<div class="top3row">
<div id="Place2nd" class="top3 col-xs-4">
	<div class="botBox">
		 <div class="textBox">
		<?PHP
		if (@isset($topVoters[1])) {
				echo '<div class="toptrop"><img src="/theme/dekaron/2nd.png" /></div>';
			echo '<div class="toppoints">'.number_format($topVoters[1]['TOTAL']).'<label>POINTS</label></div>';
			echo '<div class="topid">'.($topVoters[1]['NAME']['user_name'] == '' ? 'N/A' : $topVoters[1]['NAME']['user_name']).'</div>';
			echo '<div class="toptotal"><b>'.$topVoters[1]['VOTES'].'</b>x Votes</div>';
			echo '<div class="toplast">'.$topVoters[1]['LAST'].'</div>';
		
		} else echo 'N/A';
		?>
		</div>
		<div class="botBox2">
		2nd
		</div>
	</div>
</div>
<div id="Place1st" class="top3 col-xs-4">
	<div class="botBox">
		 <div class="textBox">
		<?PHP
		
		if (@isset($topVoters[0])) {
			echo '<div class="toptrop"><img src="/theme/dekaron/1st.png" /></div>';
			echo '<div class="toppoints">'.number_format($topVoters[0]['TOTAL']).'<label>POINTS</label></div>';
		echo '<div class="topid">'.($topVoters[0]['NAME']['user_name']  == '' ? 'N/A' : $topVoters[0]['NAME']['user_name']).'</div>';
			echo '<div class="toptotal"><b>'.$topVoters[0]['VOTES'].'</b>x Votes</div>';
			echo '<div class="toplast">'.$topVoters[0]['LAST'].'</div>';
			
		} else echo 'N/A';
		?>
		</div>
		<div class="botBox2">
		1st
		</div>
	</div>
</div>
<div id="Place3rd" class="top3 col-xs-4">
	<div class="botBox">
		 <div class="textBox">
		<?PHP
		if (@isset($topVoters[2])) {
			echo '<div  class="toptrop"><img src="/theme/dekaron/3rd.png" /></div>';
			echo '<div class="toppoints">'.number_format($topVoters[2]['TOTAL']).'
				<label>POINTS</label></div>';
			echo '<div class="topid">'.($topVoters[2]['NAME']['user_name'] == '' ? 'N/A' : $topVoters[2]['NAME']['user_name']).'</div>';
			echo '<div class="toptotal"><b>'.$topVoters[2]['VOTES'].'</b>x Votes</div>';
			echo '<div class="toplast">'.$topVoters[2]['LAST'].'</div>';
			
		} else echo 'N/A';
		?>
		</div>
		<div class="botBox2">
		3rd
		</div>
	</div>
</div>
<div class="col-xs-12">
<h4>Rest of the Vote Leaders</h4>
<?PHP
$c=0;
$color = 255;
foreach($topVoters as $rr => $r) {
	$c++;
	if ($c < 4) continue;
	$n = $r['NAME']['user_name'];
	if ($n == '') $n = 'N/A';
	echo '<div class="col-xs-8 col-sm-4">';
	echo '<div class="toprest">';
		echo '<div class="toprank">'.$c.'</div>';
		echo '<div class="toppoints" style="color:rgb('.($color).',45,18);">'.number_format($r['TOTAL']).'
		<label>POINTS</label></div>';
		echo '<div class="topid">'.$n.'</div>';
		echo '<div class="toptotal"><b>'.$r['VOTES'].'</b>x Votes</div>';
		echo '<div class="toplast">'.$r['LAST'].'</div>';
	
	echo '</div>'; 
	echo '</div>'; 
	$color = $color-10;
}

?>


</div>
<!---
<div class="col-xs-12">
<div class="alert alert-info" role="alert">
    <h4>Vote Rewards Information</h4>
    <p></p>
</div>
</div>
-->
</div>

</div>
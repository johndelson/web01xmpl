<?PHP
$s = Constants::$INFO[$sid];
	echo '<h2 class="">News and Announcements <small><a href="'.$s['Forum']['LINK'].'"><i class="fa  fa-external-link"></i> go to forums</a></small></h2>';
	//echo ApiController::widgets($sid,'forum',true);
	
	//print_r(Constants::$V['widgets']);
?>
<?PHP


$forum = array(
	'FORUMS' 	=> array(
					$s['Forum']['Notices']=>array('danger','Notices',0),
					$s['Forum']['Events']=>array('primary','Events',0),					
					$s['Forum']['Maintenance']=>array('warning','Maintenance',0),
					$s['Forum']['Patches']=>array('info','Patches',0),
					),
);

$is_connected = 1;
$ADODB_CACHE_DIR = 'cache/';
$db = ADONewConnection($s['Forum']['TYPE']);
$db->locale = 'us_english';
//$db->debug = $s['Forum']['DEBUG'];
$rs = $db->Connect($s['Forum']['HOST'], $s['Forum']['USER'], $s['Forum']['PASS'], $s['Forum']['DBNAME']) or $is_connected = 0;
$threads = array();
$sort = array();
$c = 0;


if ($is_connected == 1) {
	// THIS IS IPB TYPE
	foreach($forum['FORUMS'] as $ff => $f) {
		if ($ff == -1) continue; 
		$rs =$db->CacheExecute(3600,'select t.*,p.post from topics t  left join posts p ON 
			t.topic_firstpost = p.pid where t.forum_id = ? 
			order by start_date desc LIMIT 0 ,'.$s['Forum']['LOAD'],$ff);
		if ($rs->RecordCount() > 0) {			
			foreach($rs->GetRows() as $row => $r) {
				$threads[$c]['tid'] = $r['tid'];	
				$threads[$c]['fid'] = $r['forum_id'];
				$threads[$c]['title'] = $r['title'];	
				$threads[$c]['date'] = $r['start_date'];
				$sort[$c] = $r['start_date'];
				$threads[$c]['author'] = $r['starter_name'];
				$threads[$c]['views'] = $r['views'];
				$threads[$c]['post'] = $r['post'];
				$threads[$c]['link'] = $s['Forum']['LINK'].'/index.php?/topic/'.$r['tid'].'-'.$r['title_seo'].'/';
				$forum['FORUMS'][$ff][2]++;
				$c++;
			}
		} else echo '<div class="alert alert-warning">Empty Headlines. Visit our forums ( <a href="'.$s['Forum']['LINK'].'">'.$s['Forum']['LINK'].'</a> )</div>';
	}
	//re arrange the threads by date
	array_multisort($sort, SORT_DESC, SORT_STRING, $threads);
	// end IPB TYPE
$db->close();
} else echo '<div class="alert alert-warning">Unable to open Forums ( <a href="'.$s['Forum']['LINK'].'">'.$s['Forum']['LINK'].'</a> )</div>';
Constants::$V['widgets'] = '';
foreach($forum['FORUMS'] as $ff => $f) {
	Constants::$V['widgets'][$f[1]]  = array(
		'col'=>12,
		'display'=>true,
		'title'=>$f[1],
		'icon'=>'fa-bars',
	);
	
	Constants::$V['widgets'][$f[1]]['body'] =	'<ul class="list-unstyled headlines">';
		
	$cnt = 0;
		foreach(@$threads as $tt => $t) {
			if ($t['fid'] == $ff)  { 
			Constants::$V['widgets'][$f[1]]['body'] .= '<li><span data-toggle="tooltip" data-placement="bottom" title="'.$forum['FORUMS'][$t['fid']][1].'" class="label label-icon label-'.$forum['FORUMS'][$t['fid']][0].'">'.$forum['FORUMS'][$t['fid']][1].'</span>
				<a href="'.$t['link'].'" target="_black">'.$t['title'] .'</a> </li>';
				$cnt++;
			}
		}
	Constants::$V['widgets'][$f[1]]['body'] .=	'</ul>';
	Constants::$V['widgets'][$f[1]]['footer'] = '<a class="btn btn-sm btn-primary pull-right" href="'.$s['Forum']['LINK'].'/index.php?/forum/'.$ff.'-'.$f[1].'/"><i class="fa fa-comments"></i> read more at forums</a>
				<div class="clear"></div>';
	
	if ($cnt == 0) unset(Constants::$V['widgets'][$f[1]]);
	
	
}



?>



	
	
	
		
	

<div class="row">
<div class="col-xs-12 panel-group headline-half" id="accordion-<?PHP echo $sid; ?>">
<?PHP 
	$cnt = 0;
	foreach(@$threads as $tt => $t) {		
	  if (!in_array($t['fid'],array($s['Forum']['Notices'],$s['Forum']['Maintenance']))) continue;
	
	//if ($cnt > 0) $t['post'] =''; //class="collapse '.($cnt==1 ? 'in':'').'"
	  echo '<div class="panel bg-trans" data-filter="'.$forum['FORUMS'][$t['fid']][1].'">
			<div id="headline-'.$sid.'-'.$cnt++.'" >
				<div class="well-inverse bg-trans">
					<div class="well-title">
						<h2><span class="pull-right-abs">
			
					<span data-toggle="tooltip" data-placement="left" title="Views: '.$t['views'].'" class="label label-success">'.$t['views'].'</span> 
					<span data-toggle="tooltip" data-placement="bottom" title="Date: '.date($s['Basic']['Date Format'],$t['date']).'" class="label label-default"><i class="fa fa-clock-o"></i></span> 
					<span data-toggle="tooltip" data-placement="bottom" title="Author: '.$t['author'].'" class="label label-info"><i class="fa fa-user"></i></span> 
					
					</span>
					<i class="fa fa-comments"></i> <a href="'.$t['link'].'" target="_black">'.$t['title'] .'</a> 
					<span data-toggle="tooltip" data-placement="bottom" title="'.$forum['FORUMS'][$t['fid']][1].'" class="label label-icon label-'.$forum['FORUMS'][$t['fid']][0].'">'.$forum['FORUMS'][$t['fid']][1].'</span>'.' </h2>
					<div class="sub-title">
						by: <b>'.$t['author'].'</b> | views: <b>'.$t['views'].'</b>
						<div class="pull-right">
						'.date($s['Basic']['Date Format'],$t['date']).'
						</div>
					</div>
					</div>
					<div class="well-body">
						'.$t['post'].'
					</div>
				</div>
			</div>
			</div>';					
	}				
?>	
</div>

</div>

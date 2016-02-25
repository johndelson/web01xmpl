<?PHP

$s = Constants::$INFO[$sid];

$forum = array(
	'FORUMS' 	=> array(
		$s['Forum']['Notices']=>array('danger','Notices',0),
		$s['Forum']['Events']=>array('primary','Events',0),					
		$s['Forum']['Maintenance']=>array('warning','Maintenance',0),
		$s['Forum']['Patches']=>array('info','Patches',0),
		),
);
/*
$forum = array(
	'FORUMS' 	=> array(
		31=>array('danger','A3 Events',0),
		91=>array('primary','A9 Events',0),					
		121=>array('warning','A9 Line Events',0),
		
		),
);*/
$forumPre = '';// 'forums_';
$is_connected = 1;
$ADODB_CACHE_DIR = 'cache/';
$db = ADONewConnection($s['Forum']['TYPE']);
$db->locale = 'us_english';
$db->debug = 0;
$rs = $db->Connect($s['Forum']['HOST'], $s['Forum']['USER'], $s['Forum']['PASS'], $s['Forum']['DBNAME']) or $is_connected = 0;
$threads = array();
$sort = array();
$c = 0;


if ($is_connected == 1) {
	// THIS IS IPB TYPE
	foreach($forum['FORUMS'] as $ff => $f) {
		if ($ff == -1) continue; 
		$rs =$db->CacheExecute(0,'select t.*,p.post from '.$forumPre.'topics t  
			left join '.$forumPre.'posts p ON t.topic_firstpost = p.pid where t.forum_id = ? 
			order by start_date desc LIMIT 0 ,5',$ff);
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
				$threads[$c]['posts'] = $r['posts'];
				$threads[$c]['link'] = $s['Forum']['LINK'].'/index.php?/topic/'.$r['tid'].'-'.$r['title_seo'].'/';
				$forum['FORUMS'][$ff][2]++;
				$c++;
			}
		} 
	}
	//re arrange the threads by date
	array_multisort($sort, SORT_DESC, SORT_STRING, $threads);
	// end IPB TYPE
$db->close();
} 

echo '';
$cnt = 0;
$defaultThumb = '/theme/dekaron/newsThumb.png';

echo '<h2>Headlines from the Forum <small><a href="'.$s['Forum']['LINK'].'"><i class="fa  fa-external-link"></i> go to forums</a></small></h2>';
foreach(@$threads as $tt => $t) {
	$cnt++;
	if ($cnt==9) continue;
	//search for images in post
	$Thumb = $defaultThumb;
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i',  $t['post'], $matches);
	
	
	if ($matches[1]) {
		$c = count($matches[1]);
		$Thumb = '/s/tnail.php?width=300&height=169&file='.$matches[1][rand(0,$c-1)];
	}
	
	echo '<article class="col-xs-6 col-sm-4 col-md-3 article">';
	echo '<div class="articleDiz pull-right">'.$t['posts'].' <i class="fa fa-comment-o"></i></div>';
	echo '<div class="articleDate">'.date('M d, Y h:m a',$t['date']).'</div>';
	echo '<div class="articleImg" style="background:url('.$defaultThumb.') 0 0 no-repeat;">		
			 <img src="'.$Thumb.'">		 
		
		</div>';
	echo '<label class="label label-'.$forum['FORUMS'][$t['fid']][0].'">'.$forum['FORUMS'][$t['fid']][1].'</label> <a href="'.$t['link'].'" target="_black">'.$t['title'] .'</a>';
	
	echo '</article>';
	
}
		

//'.$forum['FORUMS'][$t['fid']][1].'" class="label label-icon label-'.$forum['FORUMS'][$t['fid']][0].'">'.$forum['FORUMS'][$t['fid']][1].'</span>
				



?>


	
	
		
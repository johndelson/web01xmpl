<div class="slider active">
	<div class="col-md-8">
	<div class="intro">
		<h2 class="featurette-heading"><i class="fa fa-users"></i> Core-Games Community</h1>
		<ul class="list-group stripe-full">		
		<li class="list-group-item">
			<div class="pull-right">
				<a href="<?PHP echo $forum['LINK']; ?>"><button class="btn btn-sm btn-circle"><i class="fa fa-external-link"></i></button></a>
			</div>	
		<a href="#community/Facebook"><button class="btn btn-sm bg-maroon btn-circle"><i class="fa fa-bullhorn"></i></button>  Forums</a>
		<ul class="list-group">		
		<?PHP foreach($Server as $srv => $s) {
			echo '<li class="list-group-item"><a href="#community/'.$s['Web']['Server Name'].'">
					<i class="fa fa-arrow-circle-o-right"></i> '.$s['Web']['Server Name'].'</a>
					</li>';			
		}
		?>
		</ul>
		
		<li class="list-group-item">
			<a href="#community/Facebook"><button class="btn btn-sm bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button> Facebook</a>
			<div class="pull-right">
				<a href="<?PHP echo Constants::FACEBOOK; ?>"><button data-toggle="tooltip" data-placement="left" title="Go to Facebook Site" class="btn btn-sm btn-circle"><i class="fa fa-external-link"></i></button></a>
			</div>		
		</li>
		<li class="list-group-item">
			<a href="#community/Twitter"><button class="btn btn-sm bg-aqua btn-circle"><i class="fa fa-twitter"></i></button> Twitter</a>
			<div class="pull-right">
				<a href="<?PHP echo Constants::TWITTER; ?>"><button data-toggle="tooltip" data-placement="left" title="Go to Twitter Site" class="btn btn-sm btn-circle"><i class="fa fa-external-link"></i></button></a>
			</div>		
		</li>
		<li class="list-group-item">
			<a href="#community/Youtube"><button class="btn btn-sm bg-red btn-circle"><i class="fa fa-youtube"></i></button> Youtube</a>
			<div class="pull-right">
				<a href="<?PHP echo Constants::YOUTUBE; ?>"><button data-toggle="tooltip" data-placement="left" title="Go to Youtube Site" class="btn btn-sm btn-circle"><i class="fa fa-external-link"></i></button></a>
			</div>		
		</li>
	
		</ul>
		</div>

</div>	

</div>

<?PHP
error_reporting(E_ALL ^E_NOTICE ^E_DEPRECATED ^E_WARNING);
require_once('lib/BBCODE/stringparser_bbcode.class.php');
require_once('lib/BBCODE/functions.php');

foreach($Server as $srv => $s) {

echo '<div class="slider" data-anchor="forum-'.preg_replace('/ /i','_',$s['Web']['Server Name']).'">';
	$forum = array(
		'FORUMS' 	=> array(
						$s['Forum']['Notices']=>array('danger','Notices'),
						$s['Forum']['Events']=>array('primary','Events'),					
						$s['Forum']['Maintenance']=>array('warning','Maintenance'),
						$s['Forum']['Patches']=>array('info','Patches'),
						),
	);

	$is_connected = 1;
	$ADODB_CACHE_DIR = 'cache/';
	$db = ADONewConnection($s['Forum']['TYPE']);
	$db->locale = 'us_english';
	$db->debug = $s['Forum']['DEBUG'];
	$rs = $db->Connect($s['Forum']['HOST'], $s['Forum']['USER'], $s['Forum']['PASS'], $s['Forum']['DBNAME']) or $is_connected = 0;
	$threads = array();
	$sort = array();
	$c = 0;
	if ($is_connected == 1) {
		// THIS IS IPB TYPE
		foreach($forum['FORUMS'] as $ff => $f) {
			if ($ff == -1) continue; 
			$rs =$db->CacheExecute(3600,'select t.*,p.post from topics t  left join posts p ON t.topic_firstpost = p.pid where t.forum_id = ? order by start_date desc LIMIT 0 ,'.$s['Forum']['LOAD'],$ff);
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
					$threads[$c]['link'] = $s['Forum']['LINK'].'index.php?/topic/'.$r['tid'].'-'.$r['title_seo'].'/';
					$c++;
				}
			} else echo '<div class="alert alert-warning">Empty Headlines. Visit our forums ( <a href="'.$s['Forum']['LINK'].'">'.$s['Forum']['LINK'].'</a> )</div>';
		}
		//re arrange the threads by date
		array_multisort($sort, SORT_DESC, SORT_STRING, $threads);
		// end IPB TYPE

	} else echo '<div class="alert alert-warning">Unable to open Forums ( <a href="'.$s['Forum']['LINK'].'">'.$s['Forum']['LINK'].'</a> )</div>';
	
	if (count($threads) > 0): 
	?>

	<div class="hidden-xs col-sm-8"  >
		<div class="panel-group headline-full" id="accordion-<?PHP echo $srv; ?>">
			<?PHP 
				$cnt = 0;
				foreach($threads as $tt => $t) {
				if ($cnt > 0) $t['post'] ='';
				  echo '<div class="panel">
						<div id="headline-'.$srv.'-'.$cnt++.'" class="collapse '.($cnt==1 ? 'in':'').'">
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
								<div class="well-body scrollThis">
									'.$t['post'].'
								</div>
							</div>
						</div>
						</div>';					
				}				
			?>	
		</div>
	</div>

<div class="col-sm-4 headlines">
	<div class="panel panel-default">
   <div class="panel-heading">
	<a href="<?PHP echo $forum['LINK']; ?>"><i class="fa fa-bullhorn"></i> 
	<?PHP echo $s['Web']['Server Name'];?></b> Headlines</a>
	</div>
	<div class="panel-body">
		<ul class="list-group">
			<?PHP 
				$cn = 0;
				$cnt = 0;
				foreach($threads as $tt => $t) {
				$cn++;
					echo '<li data-toggle="collapse" data-target="#headline-'.$srv.'-'.$cnt++.'" data-parent="#accordion-'.$srv.'" class="list-group-item animated delay-'.$cn.' fadeInRight">
							<span class="pull-right">						
								<a href="'.$t['link'].'" target="_blank"><span data-toggle="tooltip" data-placement="top" title="Go to Forum Post" class="label label-default"><i class="fa fa-external-link"></i></span></a> 
								
							</span>
						<span data-toggle="tooltip" data-placement="top" title="'.$forum['FORUMS'][$t['fid']][1].'" class="label label-icon label-'.$forum['FORUMS'][$t['fid']][0].'">'.$forum['FORUMS'][$t['fid']][1][0].'</span> 
				
						'.$t['title'].'
						
						</li>';
				if ($cn==4) $cn=0;
				}			
			?>	
			</ul>
	  </div>
</div>	
</div>
<?PHP endif; 
echo '</div>';
}
$db->close();		
?>
<div class="slider" data-anchor="Facebook" data-trigger="facebook-0" data-trigger-type="ajax"></div>
<div class="slider" data-anchor="Twitter">
	<div class="container">
	<!--<div class="twitter">
		<a class="twitter-timeline" height="500px" data-chrome="transparent" data-dnt="true" href="https://twitter.com/CoreGames1" data-widget-id="474998619896946688">Tweets by @CoreGames1</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	</div>-->
	<div class="twitter">
	<a class="twitter-timeline" height="500px" data-chrome="transparent" data-dnt="true" href="https://twitter.com/pap0t" data-widget-id="474998619896946688">Tweets by @pap0t</a>

</div>
	</div>
</div>

<div class="slider" data-anchor="Youtube">
	<div class="container">
	<div id="player"></div>  
	</div>
</div>
<?php
class DashboardController {
  public static $dashparams = array(
		//'title'=> 'Dashboard ',
		//'navTitle' => 'Dashboard',
		//'bodyClass' => 'fixed dashboard',
		//'body'=> 'dashboard.php',
		'navigation'=> true,
		'location'=>'dashboard',
		'widgetsLocation'=> 'right',
  );
  public static $sid = 0;
  public static $uid = '';
  
  /* basic reroute to dashboard */
  static public function display()  {
	if (getSession()->get(Constants::LOGGED_IN) == false)    {
        getRoute()->redirect('/login');
	} 
	$loginInfo = getSession()->get('LOGININFO');
	$firstSrv = key($loginInfo);
	getRoute()->redirect('/dashboard/'.$firstSrv.'/'.Constants::$SRVLIST[$firstSrv].'/Main');
  }
  
  /* show dashboard */
  static public function dashboard($sid,$name,$page='Main')  { 
	error_reporting(0);
    if (getSession()->get(Constants::LOGGED_IN) == false)    {
        getRoute()->redirect('/');
	}
	
	HomeController::initialize($sid,$page,$base='dashboard');
	Constants::$V = array_merge(Constants::$V,self::$dashparams);
	
	self::$sid = Constants::$V['sid'];
	
	Constants::$V['loginInfo'] = getSession()->get('LOGININFO');
	if (Constants::$SRVLIST[self::$sid] && Constants::$V['loginInfo'][self::$sid]) {
		self::$sid = $sid;
		
	} else getRoute()->redirect('/login');
	

	
	self::$uid = Constants::$V['loginInfo'][self::$sid][1];
	Constants::$V['login'] = Constants::$V['loginInfo'][self::$sid];
	Constants::$V['uid'] = self::$uid;
	
	$game = Constants::$V['game'];
	
	
	// GET ACCOUNT INFORMATION
	Constants::$V['Account'] = $game->webClientDo('getAccountById',self::$uid);
	Constants::$V['Characters'] = $game->webClientDo('getCharactersById',self::$uid);
	Constants::$V['SiteProfile'] = $game->getProfile(self::$uid);
	
	Constants::$V['title'] = '['.Constants::$V['sInfo'][self::$sid]['Web']['Server Name'] .'] ' . Constants::$V['title'];


	//Constants::$V['info'] = $info;
	Constants::$V['widgets'] = array(			
				'setting'=> static::settingsParse($game),
	);
	
	Constants::$V['vote'] = array(
		'vote' => static::voteListParse2($game),		
	);
	
	
	
	//verification announcement.
	Constants::$V['accountStatus'] = $game->webClientDo('getAccountStatus',self::$uid);
	
	$cache = 3600;
	switch($page) {	
		case 'Account':	
			Constants::$V['content'] = array(
				'info' => static::infoParse($game),		
				'character' => static::characterListParse($game),
				'logs' => static::logsParse($game)
			);
			Constants::$V['widgets'] = array(
				//'vote' => static::voteListParse($game),					
				'cash' => static::cashParse($game),	
				'setting'=> static::settingsParse($game),		
			);
			$cache = 0;
		break;
		case 'Payment':
			Constants::$V['widgets'] = array(			
				'cash' => static::cashParse($game),				
				'setting'=> static::settingsParse($game),
			);
			Constants::$V['Payment'] = $game->decodeThis('Payment','Settings');		
		break;
		case 'Server':
			Constants::$V['widgets'] = array(
				'cash' => static::cashParse($game),
				'setting'=> static::settingsParse($game),	
			);
			Constants::$V['body'] = strtolower($page.'/'.Constants::$SRVLIST[self::$sid].'/'.Constants::$SRVLIST[self::$sid]).'.php';
			$cache = 0;
		break;
		
	}
	
	/* inititalize content */
	
	ob_start();	
	echo getTemplate()->get(Constants::$V['body'], Constants::$V);
	Constants::$V['bodyContents'] =  ob_get_clean();
	
	/* initialize widgets */
	if (@$widgets)	
		Constants::$V['widgets'] = $widgets;
	
	$cnt=0;
	$col=0;
	
	$wC = '';
	foreach(Constants::$V['widgets'] as $widget => $w) { //animated bounceInRight delay-'.$cnt.'
		$id= 'widgets_'.$cnt++;
		$icon = (@$w['icon']) ? '<i class="fa '.$w['icon'].'"></i> ' : '';
		$cols = (Constants::$V['widgetsLocation'] != 'right') ? 'col-md-4 col-sm-6' : 'col-xs-12';
		$wC .= '<div class="'.$cols.'">
				<div class="panel panel-'.((@!$w['style']) ? 'dashboard':$w['style']).'">';
		if (@$w['title'])  $wC .=  '<div class="panel-heading">
								<div class="pull-right panel-tools">
									<button type="button" class="btn btn-danger btn-sm" data-toggle="collapse" data-target="#'.$id.'">
							    <i class="fa fa-minus"></i>
								</button>
								</div>
								<h3 class="panel-title">'.$icon.''.$w['title'].'</h3>
								</div>';
		$wC .=  '<div id="'.$id.'" class="collapse '.((@$w['display'] == true) ? ' in' :'').'">';
		if (@$w['body'])
			$wC .=  '<div class="panel-body">'.$w['body'].'</div>';
		if (@$w['table']) $wC .=  $w['table'];
		if (@$w['footer'])
			$wC .=  '<div class="panel-footer">'.$w['footer'].'</div>';
		$wC .=  '</div></div></div>';
	}
	Constants::$V['widgetsContents'] = $wC;
	
	//Constants::$V['content'] = getTemplate()->cacheGet(Constants::$V['body'], Constants::$V,$cache);

	echo getTemplate()->get('dashboard/header.php', Constants::$V);
    getTemplate()->display('dashboard.php', Constants::$V);
	getTemplate()->display('dashboard/footer.php', Constants::$V);
  }
  /* PAYMENT */
  static public function payment() {
	$out = array('code'=>500,'msg'=>'');
		include('lib/PAYWALL/pingback.php');
  }
   
   /* show logs data */
  static public function logsParse($game) {
	$data = $game->webClientDo('getAccountById',self::$uid);
	$ret = array('col'=>12,'icon'=>'fa-exclamation-circle','title'=>'Activity Logs','display'=>true);
	$logs = $game->getLocalLogList(self::$uid);
	
	if (is_array($logs)) {
	$ret['table'] = '<table class="table table-striped">
		<thead>
		<tr><th>#</th><th>Server</th><th>Action</th><th>Message</th><th>Date</th></tr>
	<tbody>';
	foreach($logs as $ll => $l) {
		if (strtoupper($l['action']) == 'LOGIN') continue;
		$info = Constants::$INFO[$l['server_id']];
		$ret['table'] .= '<tr>';
		$ret['table'] .= '<td>'.$l['id'].'</td>';
		$ret['table'] .= '<td>'.$info['Web']['Server Name'].'</td>';
		$ret['table'] .= '<td>'.strtoupper($l['action']).'</td>';
		$ret['table'] .= '<td>'.$l['extrainfo'].'</td>';
		$ret['table'] .= '<td>'.date($info['Basic']['Date Format'],strtotime($l['indate'])).'</td>';
		$ret['table'] .= '</tr>';
	}
	$ret['table'] .= '</tbody></table>';
	
	} else 
		$ret['body'] = 'Nothing found...';
	return $ret;
  }
  
  /* show account info */
  static public function infoParse($game) {
	$data = $game->webClientDo('getAccountById',self::$uid);

	$ret = array('col'=>12,'icon'=>'fa-user','title'=>'Account Info','display'=>true);
	$ret['table'] = '<table class="table table-striped"><tbody>';
	if (count(@$data['data']) == 0) {
		getRoute()->redirect('/logout');
	}
			foreach(@$data['data']  as $dd => $d) {
				if ($dd == 'NO') continue; //skip infos
				$ret['table'] .= '<tr><td class="tdlabel">'.strtoupper(preg_replace('/_/i',' ',$dd)).'</td><td id="'.$dd.'" class="value">'.$d.'</td></tr>';
			
			}
		$ret['table'] .= '</tbody></table>';
		
		$ret['footer'] = '<div class="hidden" id="CHANGE_PASSWORD">'.getTemplate()->get('form/changepassword.form.php').'</div>'; 
		$ret['footer'] .= '<div class="hidden" id="CHANGE_EMAIL">'.getTemplate()->get('form/changeemail.form.php').'</div>'; 
		$ret['footer'] .= '<div class="pull-right"><button class="btn btn-sm btn-primary getFrom" data-sid="'.self::$sid.'" data-action="CHANGE_PASSWORD" >
								<i class="fa fa-edit"></i> Change Password</button>';
		$ret['footer'] .= '  <button class="btn btn-sm  btn-default getFrom" data-sid="'.self::$sid.'" data-action="CHANGE_EMAIL" >
								<i class="fa fa-envelope"></i> Change Email</button>';
		/*$ret['footer'] .=  ' <button class="btn btn-sm btn-warning ajax" data-sid="'.self::$sid.'" data-action="VERIFY_MAIL" href="#">
								<i class="fa fa-mail-forward"></i> Resend Verify Mail</button>';*/
		$ret['footer'] .=  ' </div>';
		
	
	return $ret;  
  }
  
  /* character parse */
  static public function characterListParse($game) {
	$data = $game->webClientDo('getCharactersById',self::$uid);
	include('views/server/'.strtolower($game->game).'/charater.php');
	return $ret;  
  }
  
  /* cash parse */
  static public function cashParse($game) {
	$data = $game->webClientDo('getCashById',self::$uid);
	$ret = array('col'=>4,'icon'=>'fa-money','title'=>'Cash Account','display'=>true);
	$ret['table'] = '<table class="table table-striped"><tbody>';
		if (@$data['data']) {
			foreach($data['data']  as $dd => $d) {
				if ($dd == 'CASH_ID') continue;
				$ret['table'] .= '<tr><td class="tdlabel">'.strtoupper(preg_replace('/_/i',' ',$dd)).'</td><td id="'.$dd.'" class="value">'.$d.'</td></tr>';
			
			}
		}
	$ret['table'] .= '</tbody></table>';
	return $ret;  
  }
  
   /* vote parse */
  static public function voteListParse($game) {

	$data = $game->decodeDefinesArray('Vote Sites');
	$ret = array('col'=>3,'icon'=>'fa-thumbs-o-up','style'=>'dashboard','title'=>'Vote Now','display'=>true);
	$ret['table'] = '<table class="table table-striped"><tbody>';
	
	//get user info	
	$u = $game->webClientDo('getAccountById',self::$uid);
	$user = $u['data'];
	
	
	$ret['msg'] .= '<iframe src="'.$data['newLink'].'" class="iFrameVote"></iframe>';
	
	
			foreach($data as $dd => $d) {
				switch(@$d['Action']) {
					case 'xtremetop100':
						$d['Link'] = $d['Link'].'&postback='.self::$uid;
						$btn = '<a href="'.$d['Link'].'" target="_NEW"><button type="button" data-loading-text="Processing vote...">
								<img data-src="'.@$d['Imagebutton'].'" />
								</button></a>';
					break;
					default:
					case '_AJAX':
						$d['Link'] = $d['Link'];
						$btn = '<button type="button" data-loading-text="Processing vote..." 
								data-link="'.$d['Link'].'" class="ajax" data-sid="'.self::$sid.'" data-action="vote" data-id="'.$dd.'" >
								<img data-src="'.@$d['Imagebutton'].'" />
								</button>';
					
					
					break;
					case 'APIVOTE':
					case '_NEW':
						$d['Link'] = $d['Link'].'&uno='.self::$uid.'&uid='.$user['USER_ID'].'&sid='.self::$sid;
						$btn = '<a href="'.$d['Link'].'" target="_NEW"><button type="button" data-loading-text="Processing vote...">
								<img data-src="'.@$d['Imagebutton'].'" />
								</button></a>';
					break;
				}
			
				$ret['table'] .= '<tr><td class="vote-btn">
				'.$btn.'
				
				</td><td>
				Points: '.$d['Points'].' <br/>
				Repeat: '.$d['Repeat'].'
				</td></tr>';			
			}
		$ret['table'] .= '</tbody></table>';
	return $ret;  
  }
  
  
  /* vote parse version 2 */
  static public function voteListParse2($game) {

	$data = $game->decodeDefinesArray('Vote Sites');
	$ret = array('col'=>3,'icon'=>'fa-thumbs-o-up','style'=>'dashboard','title'=>'Vote for Us Now!','display'=>true);
	
	
	//get user info	
	$u = $game->webClientDo('getAccountById',self::$uid);
	$user = $u['data'];
	
	$ret['table'] = '<div id="voteLinksBox">';
	$ret['msg'] = '<iframe src="'.@$data['newLink'].'" class="iFrameVote"></iframe>';
	
			foreach($data as $dd => $d) {
				switch(@$d['Action']) {
					default:
					switch($dd) {						
						case 'xtremetop100':
							$d['Link'] = $d['Link'].'&postback='.self::$uid;
						break;
						case 'TopG':
							$d['Link'] = $d['Link'].'-'.self::$uid;	
						break;
						case 'Gtop100':
							$d['Link'] = $d['Link'].'&pingUsername='.self::$uid;	
						break;
					}
						
						$btn = '<a data-toggle="tooltip" data-placement="bottom"
									title="<h4>'.strtoupper($dd).'</h4>Points: <b>'.$d['Points'].'</b> '.@Constants::$V['label']['vote'].' 
									<br/> Repeat: <b>'.$d['Repeat'].'</b>x per 24hours"
									href="'.$d['Link'].'" target="_NEW"><button type="button" data-loading-text="Processing vote...">
								<img data-src="'.@$d['Imagebutton'].'" />
								</button></a>';
					break;				
						
				
				
					case '_AJAX':
						$d['Link'] = $d['Link'];
						$btn = '<div class="voteLink _ajax" data-toggle="tooltip" data-placement="bottom" title="Points: '.$d['Points'].' / Repeat: '.$d['Repeat'].'">
						<button type="button" data-loading-text="Processing vote..." 
								data-link="'.$d['Link'].'" class="ajax" data-sid="'.self::$sid.'" data-action="vote" data-id="'.$dd.'" >
								<img data-src="'.@$d['Imagebutton'].'" />
								</button></div>';
					
					
					break;
					case 'APIVOTE':
					case '_NEW':
						$d['Link'] = $d['Link'].'&uno='.self::$uid.'&uid='.$user['USER_ID'].'&sid='.self::$sid;
						$btn = '<a class="voteLink _api" 
							data-toggle="tooltip" data-placement="bottom"
3							title="<h4>'.strtoupper($dd).'</h4>Points: <b>'.$d['Points'].'</b> '.Constants::$V['label']['vote'].' 
							<br/> Repeat: <b>'.$d['Repeat'].'</b>x per 24hours"
							href="'.$d['Link'].'" target="_NEW">
							<button type="button" data-loading-text="Processing vote...">
								<img data-src="'.@$d['Imagebutton'].'" />
								</button></a>';
					break;
				}
			
				$ret['table'] .= $btn;
			
			}
		$ret['table'] .= '</div>';
	return $ret;  
  }
  
  /* settings parse */
  static public function settingsParse($game) {
	$data = $game->decodeDefinesArray('Statistics');
	$stats = $game->getStatistics();
	$data = array_merge($data,$stats);
	$info = Constants::$V['info'];
	$ret = array('col'=>4,'icon'=>'fa-building-o','style'=>'dashboard','title'=>'Server Settings','display'=>true);	
	$ret['table'] = '<table class="table table-striped"><tbody>';
	$ret['table'] .= '<tr><td class="tdlabel">SERVER</td><td class="value">
	'. strtoupper($info['Web']['Server Name']).'
	<br/><small><a data-toggle="tooltip" data-placement="bottom" title="Change the Server you are viewing.."
			href="#" data-target="#serverList" role="button" class="text-success modalpop">
			<i class="fa fa-retweet"></i> <i>change server</i></a></small>
	</td></tr>';
			
			foreach($data  as $dd => $d) {			
				$d = (is_numeric($d)) ? number_format($d) : $d;
				$ret['table'] .= '<tr><td class="tdlabel">'.strtoupper(preg_replace('/_/i',' ',$dd)).'</td><td id="'.$dd.'" class="value">'.$d.'</td></tr>';
			
			}
		$ret['table'] .= '</tbody></table>';
	return $ret;  
  }
  
  static public function includeFile($filename) {
    if (is_file($filename)) {
        ob_start();
        include $filename;
        return ob_get_clean();
    }
    return false;
  }
  
   
}
?>

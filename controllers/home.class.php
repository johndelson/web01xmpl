<?php
class HomeController {
	public function initialize($sid=0,$page=null,$base='home') {
		if (@Constants::$V['init'] == 200) return;
		Constants::$V['sid'] = Constants::$BASESRV; 
		if (@$sid > 0) Constants::$V['sid'] = $sid;
		
		Constants::$V['server'] = Constants::$SRVLIST[Constants::$V['sid']];
		
		$game = Constants::$SERVER[Constants::$V['sid']];
		Constants::$V['sInfo'] = Constants::$INFO;
		
		
		Constants::$V['sid'] = Constants::$V['sid'];
		Constants::$V['name'] = Constants::$V['server'];

		Constants::$V['navTitle'] = 'HOME';
		
		Constants::$V['game'] = $game;
		Constants::$V['info'] = Constants::$INFO[Constants::$V['sid']];	
		
		Constants::$V['serverURL'] = '/'.$base.'/'.Constants::$V['sid'].'/'.Constants::$V['server'];
		Constants::$V['TopNav'] = Constants::$TopNav;
		
		if ($page != null) {
		Constants::$V['page'] = $page;	
		Constants::$V['title'] = $page . ' :: Core-Games.net'; 
		Constants::$V['body'] = 'pages/'.strtolower($page).'.php'; 
		}
		
			//if ($base == 'dash') Constants::$V['body'] = 'pages/'.strtolower($page).'.php'; 
		if (@Constants::$TopNav[$page][4] == true && $base == 'home') {
			Constants::$V['body'] = 'error403.php';
		}
		Constants::$V['baseURL'] = '/'. $base .'/'. Constants::$V['sid'] .'/'. $game->game .'/';
		Constants::$V['pageURL'] = '/'. $base .'/'. Constants::$V['sid'] .'/'. $game->game .'/'.$page;
		
		@Constants::$V['bodyClass'] .= ' '.$base.' server-'.Constants::$V['sid']; 
		
		$vote = $game->decodeThis('Votes','Settings');	
		/* labels */
		Constants::$V['label']['vote'] = $vote['Vote Name'];
		Constants::$V['label']['cash'] = $vote['Cash Name'];
		
		Constants::$V['init'] = 200;
  }
	
  static public function reroute($r) {
	$r = explode('/',$r);
	$page = ucwords(strtolower($r[1]));
	echo $page ;
	
	if (!@Constants::$TopNav[$page]) $page = 'error404';

	self::home(0,'',$page);
	
  }
	/* show home */
  static public function home($sid=0,$name='',$page='home')  { 
	
	
	HomeController::initialize($sid,$page,'home');
	/* check login send to dashboard*/
    if (getSession()->get(Constants::LOGGED_IN) == true)    {
        getRoute()->redirect('/dashboard/'.Constants::$V['sid'].'/'.Constants::$V['server'].'/');
	}
	
	echo getTemplate()->get('dashboard/header.php', Constants::$V);
    getTemplate()->display('home.php',Constants::$V);
	getTemplate()->display('dashboard/footer.php', Constants::$V);

	
	
	/*self::$dashparams['info'] = $info;
	Constants::$V['widgets'] = array(			
		'setting'=> DashboardController::settingsParse($game),
	);
	
	Constants::$V['vote'] = array(
		'vote' => DashboardController::voteListParse2($game),		
	);
	*/
	
	
	
	
	//self::$dashparams['content'] = getTemplate()->cacheGet(self::$dashparams['body'], self::$dashparams,$cache);

  }
	
  static public function display($sid,$name,$page='Main')  {
    $params = array();
	$info = Constants::$INFO;

    $params['body'] = Constants::$CFG->get( 'default_module', 'Site_Setting');
    $params['title'] = Constants::$CFG->get( 'title', 'Site_Setting');
	$params['navTitle'] = 'Core-Games'; 
	$params['bodyClass'] = 'onePage static';
	$params['navigation'] = true;
	$params['Server'] = $info;
	
	//GET SLIDER DATA
	$CFG = new ConfigMagik( 'theme/slider.ini', true, true);
	$params['sliders'] = $CFG->VARS;
	$params['sid'] = Constants::$BASESRV;
	$params['serverlist'] = array();
	foreach(Constants::$SRVLIST as $srv => $s) {
		$params['serverlist'][$srv] = array($s,Constants::$INFO[$srv]['Web']['Server Name']);
	}
    getTemplate()->display('baseplate.php', $params);

  }
  static public function testMail() {
	
		$to= isset($_GET['mail']) ? $_GET['mail'] : 'johnd.ubalde@yahoo.com';			
		$subject= 'Account Email Verification :';
		$body='Your Account  has requested an ACCOUNT VERIFICATION, 
			  <br/> <br/> The Verification Link is below:  
			  <br/> <br/> 
			  <br/>
			  <br/>
			  Activation Code: 
			  <br/><br/><hr>
			  Signed<br/>';
		
		Send_Mail($to,$subject,$body);
  }
  static public function error404()  {
	 $params['title'] = 'Error 404: Page not found';
	 $params['navigation'] = false;
	 $params['bodyClass'] = 'fixedFooter';
	 $params['body'] = 'error404.php';
	 $params['message'] = 'Due to random creeps being killed you have gotten a 404 error page';
	 getTemplate()->display('baseplate.php', $params);
   
   }
   
  
  
  static public function views($sid=1,$type='error',$internal=false,$cache=10)  {  
	$key = ($internal == false) ? $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING'] : BASE_URL .'widgets/'.$sid .'/'. $type;
	$keyword_webpage = md5($key);
    $html = __c("files")->get($keyword_webpage);
	if($html == null) {
	    ob_start();
			$game = Constants::$SERVER[$sid];
			$params['sid'] = $sid;
			$params['type'] = $type;
			$file = $type;
			if (Constants::$SERVER[$sid]) {
				switch($type) {
					case 'error':
						die('Data not found');
					break;
					case 'top':			
						$params['time'] = @$_GET['time'] ? $_GET['time'] : 'Month';		
						$data = $game->webClientDo('getTopPlayers',array(6,$params['time']));			
						$params['data'] = $data['data'];	
						$file = $game->game.'-'.$file;
					break;
					case 'event':						
						$file = $game->game.'-'.$file;
					break;
					case 'info':
						$file = $game->game.'-'.$file;
						$params['time'] = @$_GET['time'] ? $_GET['time'] : 'Month';		
						$data = $game->webClientDo('getPlayerofDay',array());			
						$params['topChar'] = @$data['data'];
					break;			
				}
			}
			getTemplate()->display('views/'.strtolower($file).'.php', $params);
		 $html = ob_get_contents();
		 ob_end_flush();
         __c("files")->set($keyword_webpage,$html,($cache));
	} else 
		echo $html .'<!-- widget cache output -->';
  }
}
?>

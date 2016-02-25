<?php
class LoginController {
  public static $loginparams = array(
	'title' => 'Login page',
	'rid_id'=> 'User ID',
	'email'=> '',
	'rid_pwd'=> 'Password',
	'bodyClass'=> 'fixedFooter',
	'body'=> 'login.php',
	'navigation'=> false
	);
  public static $regparams = array(
	'title'=> 'Register page',
	//'bodyClass'=> 'fixedFooter',
	'body'=> 'register.php',
	'navigation'=> false  
  );
  static public function display()  {
    // Check if we're already logged in, although we SHOULD never get here
    if (getSession()->get(Constants::LOGGED_IN) == true)    {
        getRoute()->redirect('/dashboard');
    }	 
	self::$loginparams['serverlist'] = array();
	foreach(Constants::$SRVLIST as $srv => $s) {
		self::$loginparams['serverlist'][$srv] = array($s,Constants::$INFO[$srv]['Web']['Server Name']);
	}
	
	HomeController::initialize(@$sid,@$page,@$base='home');
	self::$loginparams = array_merge(Constants::$V,self::$loginparams);
	
	
    getTemplate()->display('baseplate.php', self::$loginparams);
  }

  static public function processLogin()  {   
	$loginCount = 0;
	$loginInfo = array();	
	self::$loginparams['message'] = '';	

	$srv = (@$_POST['server']) ? $_POST['server'] : array(Constants::$BASESRV);

	foreach($srv as $s => $sid) {
		$game = Constants::$SERVER[$sid];
		$data = $game->webClientDo('login',array($_POST['userid'],$_POST['password']));
	
		if ($data['code'] == 200) {
			$loginCount++;
			$loginInfo[$sid] = array($_POST['userid'],$data['USER_NO']); 	
			
		} else {			
			self::$loginparams['message'][$sid] = '<b>'.Constants::$INFO[$sid]['Web']['Server Name'].'</b>: '.$data['msg'];
		}
		//unset($game);
		
	}


		if ($loginCount > 0) {		
			getSession()->set(Constants::LOGGED_IN, true);
			getSession()->set('LOGININFO',$loginInfo);
			static::saveLocalLogin();	
			getRoute()->redirect('/dashboard');			
		} else {			
			static::display();
		}
	
   }
   static public function saveLocalLogin() {
		$sid = Constants::$BASESRV;
		$user = getSession()->get('LOGININFO');
		if (!isset($user[$sid])) $sid = key($user); 
	
		$game = Constants::$SERVER[$sid];
		
		$create = 0;
		$rs = $game->db->Execute('select * from front_users where user_id=?',$user[$sid][1]);
		if ($rs) {
			if ($rs->RecordCount() == 0) {
				$create = 1;				
			} 
		} else 
			$create = 1;
		if ($create == 1) {
			$data = $game->webClientDo('getAccountByIdMore',$user[$sid][1]);		
			$game->db->Execute('insert into front_users (user_id,user_name,user_email) values (?,?,?)',
				array($data['data']['USER_NO'],$data['data']['USER_ID'],$data['data']['USER_MAIL'])); 
			$rs = $game->db->Execute('select * from front_users where user_id=?',$user[$sid][1]);	
		}
		//set Arrow Chat SESSION
		$data=$rs->FetchRow();
		getSession()->set('LOGINID',$data['id']);
   }
   static public function register()  {	
		HomeController::initialize(@$sid,@$page,@$base='home');
		self::$regparams = array_merge(Constants::$V,self::$regparams);
	
		getTemplate()->display('baseplate.php', self::$regparams);
   }
   static public function processRegister()  {			
		$sid = Constants::$BASESRV;
		if (@$_POST['sid']) $sid = $_POST['sid'];
		// get first game db..
		$game = Constants::$SERVER[$sid];
		$reg = $game->webClientDo('register',$_POST);
		
		self::$regparams['code']  = $reg['code'];
		self::$regparams['message'] = $reg['msg'];
		static::register();
   }
   
   static public function activation($sid,$code) {	
		$params['title'] = 'Account Activation';
		$params['navigation'] = false;
		//$params['bodyClass'] = 'fixedFooter';
		$params['body'] = 'activation.php';
		$params['sid'] = $sid;
		if (Constants::$SERVER[$sid]) {
			$game = Constants::$SERVER[$sid];
			$data = $game->webClientDo('activation',$code);	
			$params['message'] = $data['msg'];
		} else {
			$params['message'] = 'Invalid Server';
		}
		HomeController::initialize(@$sid,@$page,@$base='home');
		$params = array_merge(Constants::$V,$params);
	
		getTemplate()->display('baseplate.php', $params);
   }
   
   /* lost password */
   static public function forgotPassword() {
    $params['serverlist'] = array();
	foreach(Constants::$SRVLIST as $srv => $s) {
		$params['serverlist'][$srv] = array($s,Constants::$INFO[$srv]['Web']['Server Name']);
	}
		$params['title'] = 'Recover Password';
		$params['navigation'] = false;
		//$params['bodyClass'] = 'fixedFooter';
		$params['body'] = 'forgotpassword.php';
		
		HomeController::initialize(@$sid,@$page,@$base='home');
		$params = array_merge(Constants::$V,$params);
	
		getTemplate()->display('baseplate.php', $params);
   
   }
   static public function processforgotPassword() {
		$sid = Constants::$BASESRV;	
		if (@$_POST['sid']) $sid = $_POST['sid'];
		// get first game db..
		$game = Constants::$SERVER[$sid];
		$data = $game->webClientDo('forgotPassword',$_POST);
	
		$params['title'] = 'Recover Password';
		$params['navigation'] = false;
		//$params['bodyClass'] = 'fixedFooter';
		
		$params['code']  = $data['code'];
		$params['message'] = $data['msg'];
		if ($data['code'] == 500) 	$params['body'] = 'forgotpassword.php';
		else {
			$params['body'] = 'activation.php';
		}
		HomeController::initialize(@$sid,@$page,@$base='home');
		$params = array_merge(Constants::$V,$params);
	
		getTemplate()->display('baseplate.php', $params);
   }   
   static public function resetPassword($sid,$code) {	
  
		$params['title'] = 'Password Reset';
		$params['navigation'] = false;
		//$params['bodyClass'] = 'fixedFooter';
		$params['body'] = 'activation.php';
		$base = Constants::$SERVER[Constants::$BASESRV];
		$newPass = $base->generatePassword(6,4);	
		if (Constants::$SERVER[$sid]) {
			$game = Constants::$SERVER[$sid];
			$data = $game->webClientDo('resetPassword',array('code'=>$code,'password'=>$newPass));	
			$params['message'] = $data['msg'];
		} else {
			$params['message'] = 'Invalid Server';
		}
		HomeController::initialize(@$sid,@$page,@$base='home');
		$params = array_merge(Constants::$V,$params);
	
		getTemplate()->display('baseplate.php', $params);
   }   
   
   /* logout */
   static public function processLogout()  {
    // Redirect to the logged in home page
    getSession()->set(Constants::LOGGED_IN, false);
	getSession()->set('LOGININFO', '');
	getSession()->set('LOGINID', '');
    getRoute()->redirect('/');
  }
}
?>

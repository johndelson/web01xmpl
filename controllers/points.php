<?php

class PointsController {
  public static $p = array(
		'debug' => 0,
		'secure_code' => 'd41d8cd98f00b204e9800998ecf842de', // must be the same as on http://game.ranks100.com/?ucp&sub=secure
		'points2give' => 12, // points to give per verified vote
		'rewardType' => 2, // 1 = CASH, 2 = VOTE
		'dayLimit' 	 => 30, // 0 for unlimited
		'rank_site_url' => 'http://game.ranks100.com/',
  );
  public static $o = array(
		'code'=>500,
		'message'=>''
  );
  
  
  //xtremetop - gtop100 - topg ...plugin in
  static public function ThirdPartyPoints($type,$sid=0,$t=0) {

	$_GET['url'] = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	//self::file_log('pointslog.txt',$_GET['url'] ."\n");
	
	if ($sid == 0) $sid = Constants::$BASESRV;
	$g = $game = Constants::$SERVER[$sid];
	$s = $g->decodeThis('Votes','Settings');
	$data = $g->decodeDefinesArray('Vote Sites');


	if (@!is_array($data[$type])) die($type .' Not found...');
	$vdata = $data[$type];			
	$params = array(				
		'id'  => $type,	
		'nores' => true,
		'time'=>date('y/d/m d:h:s a',time()),
		'sid'=>$sid,
		'points'=>$vdata['Points'],
		'repeat'=>$vdata['Repeat'],
	);

	switch($type) {
		case 'xtremetop100':
			$vdata['userno'] = $_GET['custom'];
			$params['uid'] = $_GET['custom'];
			$params['server'] = $_GET['votingip'];
		break;
		case 'TopG':
			$vdata['userno'] = $_GET['p_resp'];
			$params['uid'] = $_GET['p_resp'];
			$params['server'] =  $_SERVER['REMOTE_ADDR'];		
		break;
		case 'Gtop100':
			$params['post'] = print_r($_POST,true);
			$params['get'] = print_r($_GET,true);
			$params['server'] =  $_SERVER['REMOTE_ADDR'];	
			self::file_log('pointslog.txt',$params);
			die();
		break;
		
	}


	// save points
	if (strlen($vdata['userno']) > 5) {
		
		$vote = $g->webClientDo('vote',$params);
		//print_r($vote);
		//self::save_points($vdata,$points);	

		$params['code'] = $vote['code'];
		$params['msg'] = $vote['msg'];
		if ($params['code'] == 200) {
			//self::file_log('pointslog.txt',$params);
			$g->createLocalVoteLog($vdata['userno'],$vote['userid'],$type,$vdata['Points'],$params['server']);
		
		}
		echo $params['msg'];
	}
  }
  

  
  
  //write file log for checks
   static public function file_log($dir, $contents){ 
	$towrite = json_encode($contents) ."\n" ;

	$fh = fopen($dir, 'a+');
	fwrite($fh, $towrite);
	
	fclose($fh);
  }
  
  
  static public function display()  {
	$error = 0;
    header('Content-Type:  application/json');
	error_reporting(0);
	
    
	if(!isset($_GET['v'])) {
		self::$o['message'] = 'FAILED';
		echo json_encode(self::$o);
		die();
	}
	self::$p['debug'] = @$_GET['debug'] == 1 ? true : false;

	if(!@$_GET['method'] || !@$_GET['secure']) {
		self::$o['message'] = 'No Incoming data';
		echo json_encode(self::$o);
		die();
	} 
	// check vote info
	if (!@$_GET['userid'] && !@$_GET['votetime'] && !@$_GET['server']) {
		self::$o['message'] = 'No Vote Info';
		echo json_encode(self::$o);
		die();
	}
	// check secure code
	if (@$_GET['secure'] != self::$p['secure_code']) {
		self::$o['message'] = 'API Secure Code didn\'t match...';
		self::debug(self::$o['message']);
		echo json_encode(self::$o);
		die();
	}
	
	unset($_GET['__route__']);
	unset($_GET['v']);
	$apiData = $_GET;
	$apiData['server'] = self::$p['rank_site_url'];
	$apiData['points2give'] = self::$p['points2give'];
	$apiData['dayLimit'] = self::$p['dayLimit'];
	
	if ($apiData['method'] == 'vote') $apiData['points'] = self::$p['points2give'];
	
	
	self::debug('Communication test ['.$apiData['method'].']... starting...');		
	$apiGet = self::curlThis('POST',$apiData['server'],'api',$apiData);
	
	if ($apiGet['code']) {	
		self::debug('VERIFY DATA: ' .print_r($apiGet,true));
		self::$o['message'] = $apiGet['message'];	
		self::debug(self::$o['message']);
		if ($apiGet['code'] == 100) {		
			switch($apiData['method']) {
				case 'test':
					self::$o['apiData'] = $apiData;
					
				break;
				// admin panel send points feature to test
				case 'send':
				case 'vote':
					// lets save the points to the database;
					$user = array();
					if (isset($apiData['userid'])) $user['userid'] = $apiData['userid'];
					if (isset($apiData['userno'])) $user['userno'] = $apiData['userno'];
					$res = self::save_points($user,$apiData['points']);
					if (is_array($res)) {					
						self::$o['message'] = $res['message'];	
						self::debug(self::$o['message']);
						self::$o['code'] = 100;
					} else {
						self::$o['message'] = $res;	
						self::debug(self::$o['message']);
					}
				break;		
			}		
		} 
	} else {
		self::$o['message'] = 'Failed to get Verification';	
		self::debug(self::$o['message']);
	}
	
	echo json_encode(self::$o);

  }
  //debug
  static function debug($msg) {
	if (self::$p['debug'] == true)
		self::$o['debug'][] = $msg;

  }
  // send points 
  function save_points($udata,$points) {
	$rewardType = self::$p['rewardType'];
	//require('../init.php');
	self::debug('Initializing Save Points');
	$sid = Constants::$BASESRV;
	$g = $game = Constants::$SERVER[$sid];
	$s = $g->decodeThis('Votes','Settings');
	
	// check if user exist
	self::debug('Getting User Data:');
	$found = 0;
	if (@$udata['userno']) {
		$r = $g->webClientDo('getAccountById',$udata['userno']);
		if ($r['code'] != 200) {
			return 'User Not found';
		}
		self::debug('User found via USERNO: '.$udata['userno']);
		$found = 1;
	}
	if (@$udata['userid'] && $found == 0) {		
		$r = $g->webClientDo('getAccountByName',$udata['userid']);
		if ($r['code'] != 200) {
			return 'User Not found';
		}
		self::debug('User found via USERID: '.$udata['userid']);
	
	}
	
		$user = $r['data'];
		$userno = $user['USER_NO'];
		//debug('USER: '. print_r($r['data'],true));
		self::debug('Getting Cash Data');
		$cash = $g->webClientDo('getCashById',$userno);
		self::debug('CASH: '. print_r($cash['data'],true));
		$reward[1] = "declare @time datetime;declare @res int; exec ".$g->dbConfig('CashDB').".dbo.BL_UserCharge ?,'01',0,0,?,0,@time,@res OUTPUT";
		$reward[2] = "declare @time datetime;declare @res int; exec ".$g->dbConfig('CashDB').".dbo.BL_UserCharge ?,'01',0,0,0,?,@time,@res OUTPUT";
		$type[1] = $s['Cash Name'];
		$type[2] = $s['Vote Name'];
		self::debug('Saving Points into database');
		$g->Execute($reward[$rewardType],array($userno,$points));
		
		
	
		
		$r = $g->webClientDo('getCashById',$userno);
		$cash = $r['data'];
		$out['message'] = 'User: '.$user['USER_ID'].' ['.$userno.'] 
							<br/>Reward: <b>+'.$points.'</b> Points. 
							<br/>Total: '.$cash[$type[$rewardType]].' '.$type[$rewardType].'  ';
		$out['cash'] = $cash;
		$out['user'] = $user;
		
		// CREATE LOG 
		$g->createLocalLog($userno,'API VOTE', $out['message'] );
		$g->createLocalVoteLog($userno,$user['USER_ID'],'Ranks100',$points,$_SERVER['REMOTE_ADDR']);
		return $out;
	
    }
  
  
  // get files
	static function curlThis($method,$uri,$querry=NULL,$json=NULL,$options=NULL)	 {
		   $curl    = curl_init();
			$timeout = 30;			
			curl_setopt($curl, CURLOPT_URL, $uri."?".$querry);
			curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
			//curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
			curl_setopt($curl, CURLOPT_POST, count($json));
			curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
			$out= curl_exec($curl);
						
			return json_decode($out,true);

	}
  
  
  
  static function get_fcontent($method,$url,$querry=NULL,$json=NULL,$options=NULL, $javascript_loop = 0, $timeout = 5 ) {
	if (is_array($json)) {
		$url .= "?".$querry ."&".http_build_query($json);
	
	}
    $url = str_replace( "&amp;", "&", urldecode(trim($url)) );

    $cookie = tempnam ("/tmp", "CURLCOOKIE");
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookie );
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
    curl_setopt( $ch, CURLOPT_ENCODING, "" );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );    # required for https urls
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
    curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
    curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
	curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, $method);	

    $content = curl_exec( $ch );
    $response = curl_getinfo( $ch );
    curl_close ( $ch );

    if ($response['http_code'] == 301 || $response['http_code'] == 302) {
        ini_set("user_agent", "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");

        if ( $headers = get_headers($response['url']) ) {
            foreach( $headers as $value ) {
                if ( substr( strtolower($value), 0, 9 ) == "location:" )
                    return get_url( trim( substr( $value, 9, strlen($value) ) ) );
            }
        }
    }

    if (    ( preg_match("/>[[:space:]]+window\.location\.replace\('(.*)'\)/i", $content, $value) || preg_match("/>[[:space:]]+window\.location\=\"(.*)\"/i", $content, $value) ) && $javascript_loop < 5) {
        return get_url( $value[1], $javascript_loop+1 );
    } else {
        return array( json_decode($content,true), $response );
    }
	}  
}
?>

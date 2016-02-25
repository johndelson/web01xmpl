<?php
class ApiController {
	/* API */
  static public function api() {
	  error_reporting(0);
	$out = array('code'=>500,'msg'=>'');
	if (getSession()->get(Constants::LOGGED_IN) == false)    {
	   $out['msg'] = 'Not logged In...';
       echo json_encode($out);
	   die();
	}	
	  if (@$_GET['action'] && @$_GET['sid']) {
		$loginInfo = getSession()->get('LOGININFO');
		
		if ($loginInfo[$_GET['sid']]) {	  
			HomeController::initialize($_GET['sid'],'',$base='api');
			Constants::$V['uid'] = $loginInfo[$_GET['sid']][1];
		
			$params = array_merge($_GET,array('uid'=>$loginInfo[$_GET['sid']][1]));
			$game = Constants::$SERVER[$_GET['sid']];
			$data = $game->webClientDo($_GET['action'],$params);
			$out = $data;
			switch(@$out['do']) {
				case 'logout':
					getSession()->set(Constants::LOGGED_IN,false);
					getSession()->get('LOGININFO','');
				break;
			}	
		} else $out['msg'] = 'Server not found..';
	  } else $out['msg'] = 'Invalid Api Request..';
	  
	if (isset($_GET['callback'])) {
		//$out['callback'] = explode('/',$_GET['callback']);
		$out['callback'] = $_GET['callback'];
		
		
	}
	echo json_encode($out);
  }
  
  /* widgets file handler */
  static public function widgets($sid=1,$type='error',$internal=false,$cache=10)  {  
	$key = ($internal == false) ? $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] : 'widgets/'.$sid .'/'. $type;
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
				
			HomeController::initialize($sid,$type,$base='widget');
			$params = array_merge(Constants::$V,$params);
		
			getTemplate()->display('widgets/'.strtolower($file).'.php', $params);
			
		 $html = ob_get_contents();
		 ob_end_flush();
         __c("files")->set($keyword_webpage,$html,($cache));
	} else 
		echo $html .'<!-- widget cache output -->';
  }
  
  
	
  static public function youtube_get_list($params='') {
		
		if ($params=='') {
				$params = array(
					'q' => 'CoreDekaron',
					'maxResults' => 6,
					'type'=>'video',
					'order'=>'date'
				);
		}
		require_once 'lib/GOOGLE/Google_Client.php';
		require_once 'lib/GOOGLE/contrib/Google_YouTubeService.php';
		$DEVELOPER_KEY = 'AIzaSyAvscWvo82oc9qG6AD4C-fnJCi7r2ApJnY';
		$out = array();
		$out['msg'] = '';
		$out['data'] = '';
		$out['code'] = 500;
		
		$client = new Google_Client();
		$client->setDeveloperKey($DEVELOPER_KEY);

		$youtube = new Google_YoutubeService($client);

		try {
			$searchResponse = $youtube->search->listSearch('id,snippet', $params );
			$videos = '';
			$channels = '';
			$playlists = '';
			
			$out['data'] = $searchResponse['items'];
			if (count($out['data']) > 0) {
					$out['code'] = 200;
			}
			return $out;

	   } catch (Google_ServiceException $e) {
			$out['msg'].= sprintf('<p>A service error occurred: <code>%s</code></p>',
			  htmlspecialchars($e->getMessage()));
		} catch (Google_Exception $e) {
			$out['msg'] .= sprintf('<p>An client error occurred: <code>%s</code></p>',
			  htmlspecialchars($e->getMessage()));
	  }
	  
	  return $out;
	}
}
?>

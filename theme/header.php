<?PHP


	include('views/server/'.strtolower($game->game).'/menu.php');
	$popupSlist = '';
	Constants::$V['dropList'] = '';
	foreach(Constants::$V['sInfo'] as $serv => $s) {
			if (@!$s['Web']['Server Name']) continue;
			if (@!Constants::$SRVLIST[$serv]) continue;
			$id= preg_replace('/ /i','_',$s['Web']['Server Name']);
			$gamename = Constants::$SERVER[$serv];
			$link = ((@$loginInfo[$serv]) ? '/dashboard/' : '/home/') .$serv.'/'.$gamename->game.'/'.$page;
			$status = (@$loginInfo[$serv]) ? '<span class="text-success">Authenticated</span>' :'<span class="text-warning">Need Login</span>';
			$icon = ($serv == $sid) ? 'fa-home' : 'fa-sign-in';
			$active = ($serv == $sid) ? 'active' : '';
			$popupSlist .= '<a class="list-group-item server-list '.$active.'" href="'.$link.'">
				<div class="pull-right">
				<button class="btn btn-sm btn-success">Go</button>
				</div><i class="fa '.$icon.'"></i> <h2>'.$s['Web']['Server Name'].'</h2> ( '.$status.' )
						<br/>
						<small class="description">'.$s['Web']['Description'].'</small></a>';	
					
			$status = (@$loginInfo[$serv]) ? '<small>Authenticated</small>' :'<small>Need Login</small>';
				
			Constants::$V['dropList'] .= '<li class="'.$active.'">
			
						<a href="'.$link.'">
						<div class="pull-left">
						<img class="gameLogo" src="/theme/'.strtolower($gamename->game).'/'.strtolower($gamename->game).'_icon.png" />
						</div>
						
						<i>'.$gamename->game.'</i><br/>
						<i class="fa '.$icon.'">
						</i> '.strtoupper($s['Web']['Server Name']).' </a></li>';
											
	}
?><!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php echo $title; ?></title>
	<meta name="description" content="Play on a free Dekaron Private server. Full equiped with the latest patches and upgrades. Choose between A3 or an A9 server."/>
	<meta name="keywords" content="free, private, gaming, game, dekaron, a9, a3, free2play, download"/>
	
	
	<link type="text/css" rel="stylesheet" id="arrowchat_css" media="all" href="/arrowchat/external.php?type=css" charset="utf-8" />
    
	
	
	<link href="/theme/css/bootstrap.min.css" rel="stylesheet">
	<link href="/theme/css/bootstrapValidator.min.css" rel="stylesheet">
	<link href="/theme/css/font-awesome.min.css" type="text/css" rel="stylesheet" media="all"/>	
	<link href="/theme/css/ionicons.min.css" rel="stylesheet" type="text/css" />	

	
		
	<link href="/theme/css/main.css"  rel="stylesheet">
	
	<link href="/theme/css/main-animate.css" type="text/css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
	<link rel="shortcut icon" href="/theme/ico/favicon.ico">
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>	
	
	
	<?PHP if (getSession()->get(Constants::LOGGED_IN) == true): ?>
	<!-- dashboard css -->
	<link href="/theme/css/datatables/datatables.css" type="text/css" rel="stylesheet">
	<?PHP endif; ?>
	<!-- custom css -->
	
	
	<link href="/theme/css/styles.css" rel="stylesheet">
<style>
<?PHP 
	echo  $info['CSS']['CSS'];
?>
</style>
</head>
<body id="myBody" class="<?PHP if (@isset($bodyClass)) echo $bodyClass; ?> fixedFooter" >
<div class="wrapper">
    <div class="box">
       <div class="navbar navbar-blue navbar-static-top">  
                    <div class="navbar-header">
                      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle</span>
                        <span class="icon-bar"></span>
          				<span class="icon-bar"></span>
          				<span class="icon-bar"></span>
                      </button>
                      <a href="/" class="navbar-brand logo" data-toggle="tooltip" data-placement="bottom" title="Go back to FrontPage">
					  <i class="fa fa-home hidden-xs"></i><span class="visible-xs"><i class="fa fa-home"></i></span></a>
                  	</div>
           <nav class="collapse navbar-collapse" role="navigation">
                <ul class="nav navbar-nav">
			
			  <li class="dropdown ddgameserver">
			  <a  href="#" id="dServers" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-gear"></i> Game Servers
					<span class="caret"></span>
				  </a>
				  
				  <ul class="dropdown-menu" role="menu" aria-labelledby="dServers">
				  <?PHP echo Constants::$V['dropList']; ?>
				  
				  </ul>
			  </li>
			  <?PHP 
				
				foreach($TopNav as $mm => $m) {
					if ($m[5] == false) continue;
					$cur = ($page == $mm) ? 'active':'';
					$url = @$m[3] ? $m[3] : $serverURL.'/'.$mm;
					if (@is_array($m[3])) {
						$url = $serverURL.'/'.$mm;
						echo '<li class="dropdown '.$cur.'">
							<a  href="'.$url.'" id="d'.$mm.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							
						
							<i class="fa '.$m[0].'"></i> '.$m[1].'
							<span class="caret"></span>
						  </a>
						  <ul class="dropdown-menu" role="menu" aria-labelledby="d'.$mm.'">';
							foreach($m[3] as $sub =>$s) {
								echo '<li><a href="'.$url.'?tab='.$sub.'"><i class="fa '.$s[0].'"></i> '.$s[1].'</a></li>';
								
							}
						echo '</ul>
						</li>';
					
					} else echo '<li class="'.$cur.'"><a data-toggle="tooltip" data-placement="bottom" title="'.$m[2].'" href="'.$url.'"><i class="fa '.$m[0].'"></i> '.$m[1].'</a></li>';
				
				}
			  
			  ?>
			</ul>
      </nav>
        </div>   
        <div class="column" id="main">
			
				<!-- top nav -->
            
               
		
				<div class="mainInner">
                <!-- /top nav -->
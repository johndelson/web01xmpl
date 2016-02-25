<?PHP
Constants::$V['ServerMenu'] = '';
Constants::$V['MainNav'] = array(
	'Account' => array('fa-user','Account','Vote, View/Edit Account, Change Passwords...',
		array(
		 'info'=>array('fa-user','Account Info','info'),
		 'characters'=>array('fa-bars','Character List','Character'),
		 'logs'=>array('fa-exclamation-circle','Activity Logs','Logs'),
		)),
	'Server' => array('fa-globe','Rankings & Etc','Hero Rankings, Guilds, Live Maps and many more features...',
		array(
		 'rankings'=>array('fa-sort-numeric-asc','Rankings','Hero Rankings','tab'),
		 'guilds'=>array('fa-bars','Guilds','Guilds Rankings','tab'),
		 'livemap'=>array('fa-globe','LiveMaps','Live Maps','tab'),
		 'events'=>array('fa-sort-numeric-asc','Events','InGame Events','tab'),
		 'Topvoters'=>array('fa-thumbs-o-up','Vote Rewards','Vote Rewards','url'),
		)),
	
	);
foreach(Constants::$V['MainNav']['Server'][3] as $mm => $m) {
	$cur = ($page == $mm) ? 'active':'';
	$url = $m[3] == 'tab' ? $serverURL.'/Server?tab='.$mm : $serverURL.'/'.$mm;
	Constants::$V['ServerMenu'] .= '<li class="'.$cur.'">
		<a data-toggle="tooltip" data-placement="bottom" title="'.$m[2].'" href="'.$url.'">
		<i class="fa '.$m[0].'"></i> '.$m[1].'</a></li>';
}

?>
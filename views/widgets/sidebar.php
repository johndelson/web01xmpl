<div id="sideLogo">
	<h3><i class="glyphicon glyphicon-copyright-mark"></i> Core-Games.net</h3>
</div>
<div class="sidePanel">			
	<h4><i class="fa fa-toggle-right"></i> User Panel 

	</h4>
	<div id="userPanelBox_side" class="sidePanel_content">	
	<?PHP 
		if (@!Constants::$V['login']){
			require('views/form/login.form_small.php'); 
		} else {
			require('views/server/'.strtolower(Constants::$V['game']->game).'/login.php'); 
		}
	?>
	</div>

</div>

<div class="sidePanel">			
	<h4><i class="fa fa-toggle-right"></i> Game Servers </h4>
	<div id="gameserver_side" class="sidePanel_content">
	<ul>
	<?PHP 
	foreach(Constants::$V['sInfo'] as $serv => $s) {
		if (@!$s['Web']['Server Name']) continue;
		if (@!Constants::$SRVLIST[$serv]) continue;
		$id= preg_replace('/ /i','_',$s['Web']['Server Name']);
		$gamename = Constants::$SERVER[$serv];
		$link = ((@Constants::$V['loginInfo'][$serv]) ? '/dashboard/' : '/home/') .$serv.'/'.$gamename->game.'/';
		$status = (@Constants::$V['loginInfo'][$serv]) ? '<span class="text-success">Authenticated</span>' :'<span class="text-warning">Need Login</span>';
		$icon = ($serv == $sid) ? 'fa-home' : 'fa-sign-in';
		$active = ($serv == $sid) ? 'active' : '';
												
		echo '<li class="'.$active.'">
				
					<a href="'.$link.'" >
					<div class="pull-left">
					<img class="gameLogo" src="/theme/'.strtolower($gamename->game).'/'.strtolower($gamename->game).'_icon.png" />
					</div>
					<div class="pull-right">
					'.($serv == $sid ? 'You are here!<br/>' :$status).'
					
					
					
					</div>
					<b>'.$gamename->game.'</b><br/>
					<i class="fa '.$icon.'">
					</i> '.strtoupper($s['Web']['Server Name']).' 
					</a>
					
				</li>';
										
	}
	?>
	</ul>
		</div>
		<div class="clear"></div>

</div>
<div class="clear"></div>

<div class="sidePanel">			
	<h4><i class="fa fa-youtube-square"></i> Lastest Videos </h4>
	<div id="gameserver_side" class="sidePanel_content">
	
	<?PHP 
		Constants::$V['_GET'] = array(
			'c'=>1,
			'h'=>260,
			'w'=>230,		
		);
		echo ApiController::widgets($sid,'youtube_player',true,3600*24);
	
	
	?>
	
		</div>
		<div class="clear"></div>

</div>
<div class="sidePanel">			
	<h4><i class="fa fa-eye"></i> Game Masters List </h4>
	<div id="gameserver_side" class="sidePanel_content">
	<ul>Soonish
	<?PHP 
	
	?>
	</ul>
		</div>
		<div class="clear"></div>

</div>
<div class="sidePanel">			
	<h4><i class="fa  fa-hand-o-up"></i> Follow us! </h4>
	<div id="gameserver_side" class="sidePanel_content">
	<div class="col-xs-12 shaded">
				<a class="sh"  href="<?PHP echo Constants::TWITTER; ?>" target="_NEW" class="twitter"><i class="fa fa-twitter icon-right"></i>Twitter</a>
	</div>
	<div class="col-xs-12 shaded">
				<a class="sh"  href="<?PHP echo Constants::YOUTUBE; ?>" target="_NEW"  class="youtube"><i class="fa fa-youtube icon-right"></i>Youtube</a>
	</div>
	<div class="col-xs-12 shaded">
				<a class="sh"  href="<?PHP echo Constants::FACEBOOK; ?>" target="_NEW"  class="facebook"><i class="fa fa-facebook icon-right"></i>Facebook</a>
	</div>
		</div>
		<div class="clear"></div>

</div>

<div class="sidePanel">			
	<h4><i class="fa fa-check-square-o"></i> Rules And Regulations</h4>
	<div id="gameserver_side" class="sidePanel_content">
	<div class="col-xs-12 shList">
		<div class="sh">1. Don't be a dick.</div>
		<div class="sh">2. Scamming will punished serverly</div>
		<div class="sh">3. GMs Don't get paid so a little bit nice to them.</div>
		<div class="sh">4. no idea.. have fun.. :)</div>
	</div>
	</div>
</div>

<br/><br/>
<div class="sidePanel">
</div>
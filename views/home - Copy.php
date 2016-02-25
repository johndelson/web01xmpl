<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
	<div class="modal-content">
		
	</div>
</div>
</div>
	<div class="navbar-wrapper navbar-home">
      <div class="container">
		<nav class="navbar animated fadeIn navbar-inverse navbar-<?PHP echo (($body == 'home.php') ? 'static' : 'fixed'); ?>-top" role="navigation">
		  <!-- Brand and toggle get grouped for better mobile display -->
		  <div class="navbar-header">
			<button type="button" class="pull-left navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
			  <span class="sr-only">Toggle navigation</span>
			  <span class="icon-bar"></span>
			  <span class="icon-bar"></span>
			  <span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#"><?php echo $navTitle; ?></a>	
		  </div>
		  
			<ul class="nav navbar-nav navbar-right">	
			<?php if (getSession()->get(Constants::LOGGED_IN) == true):		?>
				<li><a href="/dashboard"><button type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-dashboard"></i> Dashboard</button></a></li>
				<li><a href="/logout"><button type="button" class="btn btn-sm btn-success"><i class="fa fa-sign-out"></i> Sign out</button></a></li>
			<?php else:	?>
				<li><a href="/register">
				<button type="button" class="btn btn-sm btn-info">
				<i class="fa fa-pencil-square-o"></i> Register</button></a></li>
			
				<li><a href="/login" data-backdrop="false" data-remote="false" data-toggle="modal" data-target="#loginModal">
				<button type="button" class="btn btn-sm btn-success">
				<i class="fa fa-sign-in"></i> Sign in</button></a></li>
				<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 class="modal-title">Login</h4>
						</div>
							<div class="modal-body">
						 <?php include('form/login.form.php'); ?>
							</div>
					</div>
				</div>
				</div>
			<?php endif; ?>
			</ul>
			
		  <!-- Collect the nav links, forms, and other content for toggling -->
		  <div class="collapse navbar-collapse" id="navbar-collapse-1">
			<ul id="menu" class="nav navbar-nav">
			  <li class="active" data-menuanchor="home"><a href="#home"><i class="fa fa-home"></i> Home</a></li>
			  <li  class="dropdown"  data-menuanchor="community">
				<a href="#community"><i class="fa fa-users"></i> Community</a>	
			  </li>
			   <li  class="dropdown">
				<a href="http://forum.core-games.net/"><i class="fa fa-comments-o"></i> Forum</a>	
			  </li>
			  
			  <li class="dropdown" data-menuanchor="servers" >
				  <a data-toggle="dropdown" href="#servers"><i class="fa fa-desktop"></i> Server List</a>
				  <ul class="dropdown-menu animated fadeIn" role="menu" aria-labelledby="dLabel">
					<?PHP
					foreach($Server as $serv => $s) {
						$id= preg_replace('/ /i','_',$s['Web']['Server Name']);
						echo '<li data-menuanchor="'.$id.'"><a href="#'.$id.'"><label class="label label-warning">Server</label> '.$s['Web']['Server Name'].'</a></li>';					
					}
					?>
				  </ul>
				
			  </li>
			  
			  <li  data-menuanchor="downloads"><a href="#downloads"><i class="fa fa-download"></i> Downloads</a></li>
			</ul>
	
         </div><!--/.navbar-collapse -->
     	
		</nav>

      </div>
    </div>
	
	<div id="fullpage">
    <div data-id="home" id="myCarousel" class="section carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <?PHP
			$default = 'REGISTER';
			$cnt = 0;
			foreach($sliders  as $sl => $s) {
				echo '<li data-target="#myCarousel" data-slide-to="'.$cnt++.'" class="'.(($default == $sl) ? 'active' : '').'"></li>';
			}	
		?>
        
      </ol>
      <div class="carousel-inner">
	  
		<?PHP 
			$default = 'REGISTER';
			$cnt = 0;
			foreach($sliders  as $sl => $s) { ?>
				<div class="item <?PHP echo (($default == $sl) ? 'active' : ''); ?>" style="background:url(<?PHP echo $s['IMAGE_LINK'];?>) no-repeat scroll 10% -10px transparent;" >          
				  <div class="container">
					<div class="carousel-caption">
					 <h2 class="featurette-heading"><?PHP echo $s['HEADLINE'];?></h2>
					  <?PHP echo $s['TEXT'];?>						
					  </p>
					  <p><a class="btn btn-lg btn-info" href="<?PHP echo $s['BUTTON_LINK'];?>" role="button"><i class="fa fa-pencil-square-o"></i> <?PHP echo $s['BUTTON_TEXT'];?></a></p>
					</div>
				  </div>
				</div>
		<?PHP 
			}	
		
		?>
        
    
	
      </div>
      <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
   </div>
  
	

<div data-trigger=".tab-ajax .active a" data-trigger-type="click" data-id="community" class="section bg-2">
	<?PHP
	// we try to get NEWS/FORUM
	include('community.php');
	
	?>   
</div>
	<?PHP
	$cnt=1;
	$cache = $GLOBALS['cache'];
	//print_r($cache);
	foreach(Constants::$INFO as $serv => $s) {
		//$game = Constants::$SERVER[$serv];
		//$topHero = $game
	?>
			<div data-trigger=".tab-ajax .active a" data-trigger-type="click" data-id="<?PHP echo preg_replace('/ /i','_',$s['Web']['Server Name']); ?>" class="section bg-<?PHP echo $cnt++;?>">
			  <div class="row serverPage featurette">
				
				<div class="col-sm-10 animate <?PHP echo (($cnt % 2) != 1) ? 'pull-right fromLeft' :'fromRight'; ?> ">
				
				 
				  <div class="col-xs-12 darkTab">	
					<ul class="nav nav-tabs tab-ajax">
					  <h2 class="featurette-heading"><?PHP echo $s['Web']['Server Name']; ?></h2>
					  <li class="active"><a href="#info-<?PHP echo $serv; ?>" data-toggle="tab"><i class="fa fa-info"></i> Server Info</a></li>
					  <li><a href="#top-<?PHP echo $serv; ?>" data-target="" data-toggle="tab"><i class="fa fa-bar-chart-o"></i> Top Players</a></li>
					  <li><a href="#event-<?PHP echo $serv; ?>" data-toggle="tab"><i class="fa fa-clock-o"></i> Events</a></li>				
					</ul>

					<div class="tab-content">
					<div class="tab-pane active bg-trans animated fade in" id="info-<?PHP echo $serv; ?>"><?PHP ApiController::widgets($serv,'info',true); ?></div>
					<div class="tab-pane fade bg-trans" id="top-<?PHP echo $serv; ?>"></div>
					<div class="tab-pane fade bg-trans" id="event-<?PHP echo $serv; ?>"></div>					
					</div>
					
				</div>
				</div>
					
				</div>
		
			
			</div>
		
		<?PHP				
	}
	?>	
	<div data-id="downloads" class="section bg-3">
 
      <div class="row downloadsPage featurette">
        <div class="col-md-3 hidden-xs hidden-sm animate fromLeft">
          <!--<img class="featurette-image img-responsive" data-src="/theme/img/downloads.jpg" alt="Downloads">-->
        </div>
        <div class="col-md-6 animate fromRight">
          <h2 class="featurette-heading">Downloads. <span class="text-muted">we got them here.</span></h2>
          <div class="col-xs-12 darkTab">	
					<ul class="nav nav-tabs tab-ajax">
					<?PHP 
					$cnt=0;
					foreach(Constants::$INFO as $serv => $s) {
						$class =$cnt==0 ? 'active' :'';
					?>
						<li class="<?PHP echo $class; ?>"><a href="#download-<?PHP echo $serv; ?>" data-toggle="tab"><i class="fa fa-info"></i> <?PHP echo $s['Web']['Server Name']; ?></a></li>
					<?PHP
						$cnt++;
					}
					?>					
					</ul>

					<div class="tab-content">
						<?PHP 
						$cnt=0;
						foreach(Constants::$INFO as $serv => $s) {
							$game = Constants::$SERVER[$serv];
							$downloads = $game->decodeDefinesArray('Downloads');
							$class =$cnt==0 ? 'active' :'';
						?>
							<div class="tab-pane <?PHP echo $class; ?> bg-trans animated fade in" id="download-<?PHP echo $serv; ?>">
								<div class="list-group">	
									<?PHP foreach($downloads as $dl => $d) {
										echo '<a href="'.$d.'" class=" bg-trans list-group-item"><i class="fa  fa-cloud-download"></i> '.$dl.'</a>';
									}
									?>
								</div>
								
							</div>
						<?PHP
							$cnt++;
						}
						?>	
					
					
					</div>
					
				</div>
        </div>
      </div>

    </div>

</div>


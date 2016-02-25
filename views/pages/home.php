<div class="no-padding">

<?PHP
	$cnt=1;
	$cache = $GLOBALS['cache'];
	//print_r($cache);
	  
	foreach($sInfo as $serv => $s) {
		//$game = Constants::$SERVER[$serv];
		//$topHero = $game
	?>
			<div data-trigger=".tab-ajax .active a" data-trigger-type="click" 
			data-id="<?PHP echo preg_replace('/ /i','_',@$s['Web']['Server Name']); ?>" 
			class="section2">
			
				
				<div class="col-sm-12 col-xs-12">
				
				 <h2 class="featurette-heading"><?PHP echo $s['Web']['Server Name']; ?></h2> 
				 <div class="col-xs-12 bg-trans2 ">						
					 <?PHP echo $s['Web']['Description']; ?>
				</div>
				<div class="clear"><br/></div>
	
				<div class="col-xs-12 no-padding darkTab">	
					<ul class="nav nav-tabs tab-ajax">
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
				<div class="clear"><br/></div>
			
			
		
		<?PHP				
	}
	?>	
</div>
<div class="clear"></div>
<h2 class="">Downloads. <small class="text-muted">we got them here.</small></h2>
        <div class="col-md-12">
  
          <div class="col-xs-12 darkTab">	
					<ul class="nav nav-tabs tab-ajax">
					<?PHP 
					$cnt=0;
					foreach(Constants::$INFO as $serv => $s) {
						$class =$cnt==0 ? 'active' :'';
					?>
						<li class="<?PHP echo $class; ?>">
						<a href="#download-<?PHP echo $serv; ?>" data-toggle="tab">
						<i class="fa fa-info"></i> <?PHP echo $s['Web']['Server Name']; ?></a></li>
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
										echo '<a href="'.$d.'" class=" bg-trans list-group-item"><i class="fa  fa-cloud-download"></i> <b style="color:#ff0;">'.$s['Web']['Server Name'].'</b> - '.$dl.'</a>';
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
   
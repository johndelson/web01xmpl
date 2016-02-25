	<div class="ProfilePic hidden">
	<img src="/theme/img/profile-photo.jpg" />
		<center>
		<button data-toggle="tooltip" data-placement="bottom" title="Update Website Profile" 
		href="#"  data-action="UPDATE_PROFILE" role="button" class="btn  btn-xs getFrom modalpop">
			Update</button>
		</center>
	</div>
	<div class="ProfileData">
		<div class="row">
			<div class="col-xs-12 shaded">
				<a  class="sh" data-toggle="tooltip" data-placement="right" 
					title="Change Password  <br/> Change Email  <br/> Update Account Informations" 
					href="<?PHP echo $serverURL; ?>/Account?tab=info">
					<i class="fa btn btn-xs btn-primary fa-edit icon-right"></i>
					Account Update
				</a>		
			</div>
			<div class="col-xs-12 shaded">
				<a  class="sh"  data-toggle="tooltip" data-placement="right" 
					title="Read your recent website activities..."
					href="<?PHP echo $serverURL; ?>/Account?tab=logs">
					<i class="fa fa-file-text-o btn btn-xs btn-default icon-right"></i>
					Recent Activities
					</a>
			</div>
			<div class="col-xs-12 shaded">
				<div class="sh"  data-toggle="tooltip" data-placement="right" 
					title="Reset your Character <br/>
							Add Stats <br/>
							Teleport"
					
					href="<?PHP echo $serverURL; ?>/Account?tab=character">
						<i class="fa  btn btn-xs btn-danger fa-users  icon-right"></i>
					Character List	
				
					<small>Characters On this Server [<b><?PHP echo strtoupper($info['Web']['Server Name']); ?></b>].</small>
					<div class="row">
					<?PHP
					/*background-image:url(/theme/s/'. echo $serverid.'/img/CLASS/mini_'+d.CL+'.png);data-toggle="popover" 
							data-placement="right"
							data-trigger="hover" 
							title="'.$c['NAME'].'" 
							data-content="
								Level: '.$c['LEVEL'].' <br/>
								Class: '.$c['CLASS'].' <br/>
								Map: '.$c['MAP'].' <br/>
						
							"*/

					if (intval($Characters['code']) == 500) echo $Characters['msg'];
					else {						
						foreach($Characters['data'] as $cc => $c) {
							
							echo '<div class="col-xs-6 shList">';
							echo '<a class="sh" 
							href="'.$serverURL.'/Account?tab=character#'.$c['NO'].'">'.$c['NAME'].'</a>';
							
							echo '</div>';
						}
						
					}
					
					?>
					</div>
				</div>
			</div>
			<div class="col-xs-12 shaded">
				<div class="sh" 
					
					href="<?PHP echo $serverURL; ?>/Account?tab=character">
						<i class="fa  btn btn-xs btn-danger fa-wrench  icon-right"></i>
					Website Exclusives	
					<small class="text-warning">Some features are still in beta. There will be bugs.</small>
					<div class="row">
						<div class="col-xs-6 shList">
							<a class="sh" href="<?PHP echo $serverURL; ?>/Vault">Item Vault</a>							
						</div>
						<div class="col-xs-6 shList">
							<a class="sh" href="<?PHP echo $serverURL; ?>/Shop">Webshop</a>							
						</div>
						<div class="col-xs-6 shList">
							<a class="sh" href="<?PHP echo $serverURL; ?>/Auction">Auction</a>							
						</div>
						<div class="col-xs-6 shList">
							<a class="sh" href="<?PHP echo $serverURL; ?>/Casino">Casino</a>							
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 shaded">
				<div>
					 <a class="sh signout" data-toggle="tooltip" data-placement="bottom" title="Logout of your Account!" role="button" href="/logout" class="btn logoutbtn btn-sm btn-primary">
						<i class="fa fa-sign-out icon-right"></i> Sign Out
					 </a>
				</div>
			
			</div>
			
		</div>


	</div>


<div class="clear"></div>

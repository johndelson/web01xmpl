<?PHP
//verification announcement.
if (@$accountStatus['msg']) {
	$alert = $accountStatus['code'] == 500 ? 'danger' : 'success';
	?>
	<div class="row  animated fadeInLeftBig" id="mainAlerts">
		<div class="alert alert-<?PHP echo $alert; ?> alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			  <h3><i class="fa fa-bell"></i> <?PHP echo $accountStatus['title']; ?></h3>
			  <div style="padding:0 10px;">
				
					<?PHP echo $accountStatus['msg']; ?>
				
				</div>
			</div>
	</div>
	<?PHP 

} else {

// display vote box 
?>
	<div class="row  animated fadeInRightBig" id="mainAlerts">
		<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert">
			  <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			  <h3><i class="fa fa-bell"></i> <?PHP echo $vote['vote']['title']; ?></h3>
			  <div style="padding:4px 10px;">
				
					<?PHP echo($vote['vote']['table']); ?>
				<div class="clear"></div>
			  <div class=""><a href="<?PHP echo $serverURL; ?>/Topvoters"><i class="fa fa-thumbs-o-up"></i> Top Voters of this Month ( Vote Rewards )</a></div>
			  </div>
		</div>


	</div>
	<div class="clear"></div>
<?PHP } ?>	
<div class="row widget">
<?PHP
$s = Constants::$INFO[$sid];
?>		  
					

	<div class="col-md-8 col-xs-12 serverStats">
		<div class="col-sm-6  col-xs-12">
		<?PHP
		foreach($s['Statistics'] as $l => $v) {
			$v = ($v > 0) ? number_format($v) : $v; 
			echo '<div class="col-xs-12 bg-trans">
					<span class="pull-right">'.$v.'</span> 
			'.$l.'</div>';
		}
		?>
		</div>
		
		
		<div class="col-sm-6  col-xs-12">
		<?PHP
			foreach($s['Info'] as $l => $v) {
				$v = (is_numeric($v)) ? number_format($v) : $v; 
				echo '<div class="col-xs-12 bg-trans">
					<span class="pull-right"><b>'.$v.'</b></span> 
			'.$l.'</div>';
			}
		?>
		</div>		
	</div>
	<div class="col-md-4 col-xs-12">
	<div class="col-sm-12">
		<h3 class="title-sm"><i class="fa fa-map-marker"></i> Hero of the Day</h3>
		<?PHP
		$setting = Constants::$INFO[$sid];
		$servertype = $setting['Basic']['Server ID'];
		$skip = array('NO','CL','NAME','CLASS','RANK');
		$res = '/theme/s/'.$servertype;
		$cnt=0;
		if (is_array($topChar)) {
		foreach($topChar as $dd => $d) {
		$cnt++;
		?>
			<div class="col-xs-12">
				<div class="bg-trans tophero">
				<img align="left" src="<?PHP echo $res; ?>/img/CLASS/mini_<?PHP echo $d['CL'];?>.png" class="top-class-img">
				<div class="pull-right">
					<span data-original-title="Rank" data-toggle="tooltip" data-placement="top" title="" class="label label-icon label-warning"><?PHP echo $cnt; ?></span>
						<?PHP 
							if (@$d['RANK']) echo '<br/><small>'.$d['RANK'].'</small>';
						?>
					</div>
					<b><?PHP echo $d['NAME']; ?><br/></b>
					<?PHP echo $d['CLASS']; ?><br/>
				<small>
				<?PHP
					foreach($d as $l => $v) {
						if (in_array($l,$skip)) continue;
						echo '<span class="label-cover"><span data-original-title="'.$l.'" data-toggle="tooltip" data-placement="top" title="" class="label label-icon label-primary">'.$l.'</span> '.$v.'</span>';
					}
				?>
				</small>
				</div>
			</div>
		<?PHP } } ?>
	</div>
	<div class="hidden col-sm-12 col-xs-12">
		<h3 class="title-sm"><i class="fa fa-clock-o"></i> Server Events</h3>
		<div class="col-xs-12">
			<div class="bg-trans events">
			
			
			</div>
		</div>
	</div>
	</div>
</div>
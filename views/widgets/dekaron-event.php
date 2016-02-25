<?PHP
	$game = Constants::$SERVER[$sid];
	$info = Constants::$INFO[$sid];
?>
<div class="row widget">
<div class="col-xs-12 widget-header">
	<?PHP echo date($info['Basic']['Date Format'],time()); ?>
	<div class="pull-right">
		<button data-action="REFRESH" class="btn btn-sm btn-primary"><i class="fa fa-refresh"></i></button>
	</div>

</div>	
<div class="col-xs-12 widget-body">
<?PHP
	$events = $game->decodeDefinesArray('Events');
	$hour = intval(date('G',time()));
	
?>
<div class="table-responsive">
	<table class="table crossed table-condensed">
	<?PHP for($x=0;$x <= 25; $x++) {
	 echo '<colgroup></colgroup>';
	}
	?>
	<thead><tr class="bg-trans"><th>Event</th>
	<?PHP for($x=0;$x <= 24; $x++) {
			$now = ($x == $hour) ? 'bg-teal' :'old';
			if ($x > $hour) $now = '';
			echo '<th class="'.$now.'"><span data-original-title="'.$x.':00" data-toggle="tooltip" data-placement="top">'.$x.'</span></th>'; 
	}
	?>
	</tr></thead>
	<tbody>
	<?PHP
		foreach($events as $ee => $e) {
			echo '<tr><td>'.$ee.'</td>
				';
				//print_r($e);<td colspan="25">
			$times = array();
			foreach($e as $aa => $a) {		
				$b = explode(':',$aa);
				$times[$b[0]] = array($aa,$a);
			}	
			for($x=0;$x <= 24; $x++) {
				$now = ($x == $hour) ? 'bg-teal' :'old';
				if ($x > $hour) $now = '';
				$time = (@$times[$x]) ? '<i data-original-title="'.$times[$x][0].' - '.$times[$x][1].'" data-toggle="tooltip" data-placement="top" class="fa fa-clock-o"></i>' : '';		
				echo '<td  class="'.$now.'">'.$time.'</td>';
			}
			/*echo '<div class="progress">';	
			for($x=0;$x <= 24; $x++) {				
				$active = (@in_array($x,$times)) ? 'progress-bar progress-bar-success' : 'progress-bar';
				echo '<div class="'.$active.'" style="width: 4.166666666666667%">						
					  </div>';				
			}				
			echo '</div>';</td>
			*/
			echo '</tr>';
		
		}
	
	?>
	
	
	</tbody>
	
	<tfoot><tr  class="bg-trans"><th>Event</th>
	<?PHP for($x=0;$x <= 24; $x++) {
			$now = ($x == $hour) ? 'bg-teal' :'old';
			if ($x > $hour) $now = '';
			echo '<th class="'.$now.'">'.$x.'</th>'; 
	}
	?>
	</tr></tfoot>
	</table>
</div>

</div>
</div>

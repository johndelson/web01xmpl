<div class="row widget">
<div class="col-xs-12 widget-header">
	<div class="pull-right">
		<button data-action="REFRESH" class="btn btn-sm btn-primary"><i class="fa fa-refresh"></i></button>
	</div>
</div>	
<div class="col-xs-12 widget-body">
<?PHP
$setting = Constants::$INFO[$sid];
$servertype = $setting['Basic']['Server ID'];
$skip = array('NO','CL','NAME','CLASS','RANK');
$res = '/theme/s/'.$servertype;
$cnt=0;
foreach($data as $dd => $d) {
$cnt++;
?>
	<div class="col-xs-12 col-md-6">
		<div class="bg-trans tophero">
		<img align="left" src="<?PHP echo $res; ?>/img/CLASS/mini_<?PHP echo $d['CL'];?>.png" class="top-class-img">
		<div class="pull-right text-right">
			<span data-original-title="Rank" data-toggle="tooltip" data-placement="top" title="" class="label label-icon label-warning"><?PHP echo $cnt; ?></span>
			<?PHP 
				if (@$d['RANK']) echo '<br/><small>'.$d['RANK'].'</small>';
			?>
		</div>
			<b><?PHP echo $d['NAME']; ?><br/></b>
			<small><?PHP echo $d['CLASS']; ?></small><br/>
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
<?PHP } ?>
</div>
</div>

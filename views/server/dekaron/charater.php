<?PHP
$charCount = count(@$data['data']) > 0  ? count(@$data['data']) : '0';
	$ret = array('col'=>12,'display'=>true,'title'=>'Character List','icon'=>'fa-bars','badge'=>$charCount);
	$inner = array('MAP','MONEY','POINTS');
	$main = array('NAME','CLASS','LEVEL','REBORN','PVP');
	$skip = array('MAPID','CL','NO');
	if (count(@$data['data']) > 0 ) {
	 $reborn = $game->decodeThis('Reborn','Settings'); 	
	 $dashboard = $game->decodeThis('Dashboard','Settings'); 

	 $ret['table'] = '';	 
	 if ($dashboard['Rename'] == 1)	{
		$ret['table'] .= '<div class="hidden" id="RENAME">'.getTemplate()->get('form/rename.form.php').'</div>';	
	 }
	 if ($dashboard['Teleport'] == 1)	{
		$teleport = $game->decodeDefinesArray('Teleport');
		$ret['table'] .= '<div class="hidden" id="TELEPORT">'.getTemplate()->get('form/teleport.form.php',array('teleport'=>$teleport)).'</div>';
	 }
	
	 $ret['table'] .= '<table id="MyCharacters" class="table table-striped"><thead><tr><th></th>';
	
		foreach($data['data'][key($data['data'])]  as $dd => $d) {
			if (!in_array($dd,$main)) continue;			
			$ret['table'] .= '<th>'.$dd.'</th>';
		}
		$ret['table'] .=  '</tr></thead><tbody>';
		$cnt = 1;
		foreach($data['data']  as $dd => $d) {
			$content = '			
			<div class="col-xs-12" style="background:url(/theme/s/'.$game->dbServerID.'/img/CLASS/mini_'.$d['CL'].'.png) 0 0 no-repeat;">
				<ul class="list-inline pull-right">';
			if ($reborn['Reborn State'] == 1) {		
				$label = 'RESET';
				$icon = ($d['LEVEL'] >= $reborn['Reset Level']) ? 'fa-check-square' : 'fa-ban';
				$disabled = ($d['LEVEL'] >= $reborn['Reset Level']) ? '' : 'disabled';
				$content .=  '<li><button class="ajax btn btn-sm btn-warning" data-sid="'.self::$sid.'" data-action="RESET" data-id="'.$d['NO'].'" '.$disabled.'><i class="fa '.$icon.'"></i> '.$label.'</button></li>';
			}
			if ($dashboard['Rename'] == 1)	{
				$icon = ($d['MONEY'] >= $dashboard['Rename Pay']) ? 'fa-pencil-square' : 'fa-ban';
				$content .=  '<li><button class="getFrom  btn btn-sm btn-danger" data-sid="'.self::$sid.'" data-action="RENAME" data-id="'.$d['NO'].'" href="#"><i class="fa '.$icon.'"></i> RENAME</button></li>';
			}
	
			if ($dashboard['Teleport'] == 1) {
				$icon = ($d['MONEY'] >= $dashboard['Teleport Pay']) ? 'fa-globe' : 'fa-ban';
				$content .=  '<li><button class="getFrom btn btn-sm btn-info" data-sid="'.self::$sid.'" data-action="TELEPORT" data-id="'.$d['NO'].'" href="#"><i class="fa '.$icon.'"></i> TELEPORT</button></li>';
			}
		
			$content .= '</ul>
			<div class="col-xs-12">';
			foreach(array('STR'=>'success','CON'=>'warning','DEX'=>'danger','SPR'=>'default') as $l => $v) {
				$content .= '<div class="col-xs-3">
					<div class="inner-info">
						<div data-toggle="popover" class="pull-right btn statAdderBtn"><i class="fa fa-plus-square"></i></div>
						<label class="label label-'.$v.'">'.$l.'</label> 
						<span data-sid="'.self::$sid.'" data-action="statAdder" data-type="'.$l.'" data-id="'.$d['NO'].'" id="'.$l.'-'.$d['NO'].'">'.$d[$l].'</span></div>
					</div>';
			}
			foreach($d as $l => $v) {
				if (in_array($l,$skip)) continue;
				if (!in_array($l,$inner)) continue;
				$content .=  '<div class="col-xs-3">
				<div class="inner-info">
					<label class="label label-primary">'.$l.'</label> 
					<span id="'.$l.'-'.$d['NO'].'">'.$v.'</span></div>
				</div>';
				
			}
			$content .= '</div>
			</div>';
		
		
			$ret['table'] .=  '<tr>';
			$ret['table'] .=  '<td class="details-control" data-toggle="collapse" data-target="#col_'.$d['NO'].'">';	
		
			
			$ret['table'] .= '<a name="'.$d['NO'].'"></a></td>';
			$tdCnt = 1;
			foreach($d as $l => $v) {
				if (!in_array($l,$main)) continue;							
				$ret['table'] .=  '<td id="'.$l.'-'.$d['NO'].'" >'.$v.'</td>';
				$tdCnt++;
			}
			$ret['table'] .=  '</tr>';
			$ret['table'] .=  '<tr ><td colspan="'.$tdCnt.'"><div class="collapse in" id="col_'.$d['NO'].'">'.$content.'</div></td></tr>';
			$cnt++;
		}
		$ret['table'] .= '</tbody></table>';
	} else {
		$ret['body'] = 'No Characters Found...';
	}
?>
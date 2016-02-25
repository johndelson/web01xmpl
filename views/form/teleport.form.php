<form class="form" role="form"
	data-bv-message="This value is not valid"
	data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
	data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
	data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
	<div class="form-group  row">
	<label class="col-lg-12 control-label">MAPS</label>
	<div class="col-lg-12">
<?PHP

		$cnt = 0;  
		foreach($teleport as $tt => $t) {
			$cls = ($cnt == 0) ? ' data-bv-message="Please a Teleport location" data-bv-notempty="true" ' : '';
			echo '<div class="col-xs-3"><label > <input type="radio" name="tele" value="'.$t['ID'].'" 
								data-bv-message="Please a Teleport location" 
								data-bv-notempty="true" '.@$cls.' />
							   &nbsp;'.$tt.'
							  </label></div>';	
			$cnt++;
		}
?>	
</div></div><hr><button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
<button type="submit" class="btn btn-go btn-primary">Teleport Me!</button></form>


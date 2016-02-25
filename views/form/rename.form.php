<form class="form-horizontal" role="form" autocomplete="on"
	data-bv-message="This value is not valid"
	data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
	data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
	data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
<div class="form-group">
	<label class="col-lg-3 control-label">NEW NAME</label>
	<div class="col-lg-5">
		<input type="text" class="form-control" name="NAME" value=""
			data-bv-message="The NAME is not valid"

			data-bv-notempty="true"
			data-bv-notempty-message="The NAME is required and cannot be empty"

			data-bv-regexp="true"
			data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
			data-bv-regexp-message="The NAME can only consist of alphabetical, number, dot and underscore"

			data-bv-stringlength="true"
			data-bv-stringlength-min="6"
			data-bv-stringlength-max="30"
			data-bv-stringlength-message="The NAME must be more than 6 and less than 30 characters long" />
	</div>
</div>
<hr/>
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
<button type="submit" class="btn btn-go btn-primary">Rename Me!</button></form>
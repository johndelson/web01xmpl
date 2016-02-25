<form class="form-horizontal" role="form" autocomplete="off"
	data-bv-message="This value is not valid"
	data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
	data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
	data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
	<div class="form-group">
		<label class="col-sm-3 control-label">Email Address</label>
		<div class="col-sm-5">
			<input class="form-control" name="email" type="email"
				data-bv-emailaddress="true"
				data-bv-emailaddress-message="The input is not a valid email address" 
				
				data-bv-stringlength="true"
				data-bv-stringlength-min="6"
				data-bv-stringlength-max="50"
				data-bv-stringlength-message="The Email Address must be more than 6 and less than 50 characters long" />
		</div>
	</div> 
	<div class="form-group">
		<label class="col-sm-3 control-label">Old Password</label>
		<div class="col-sm-5">
			<input type="password" class="form-control" name="old_password"
				data-bv-notempty="true"
				data-bv-notempty-message="The password is required and cannot be empty"

				 />
		</div>
	</div>
	<hr>
	<div class="form-group">
		<label class="col-sm-3 control-label">New Password</label>
		<div class="col-sm-5">
			<input type="password" class="form-control" name="password"
				data-bv-notempty="true"
				data-bv-notempty-message="The password is required and cannot be empty"

				data-bv-identical="true"
				data-bv-identical-field="confirmPassword"
				data-bv-identical-message="The password and its confirm are not the same" />
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label">Retype password</label>
		<div class="col-sm-5">
			<input type="password" class="form-control" name="confirmPassword"
				data-bv-notempty="true"
				data-bv-notempty-message="The confirm password is required and cannot be empty"

				data-bv-identical="true"
				data-bv-identical-field="password"
				data-bv-identical-message="The password and its confirm are not the same"
				
				data-bv-identical="true"
				data-bv-identical-field="password"
				data-bv-identical-message="The password and its confirm are not the same" />
		</div>
	</div>
	<hr/><button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
	  <button type="submit" class="btn btn-go btn-primary">Change Password!</button>
</form>
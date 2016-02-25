<form action="/forgotpass" id="loginForm" class="form-horizontal" method="post"
		data-bv-message="This value is not valid"
		data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
		data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
		data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">		
		
	<div class="form-group">
		<label class="col-sm-3 control-label">Username</label>
		<div class="col-sm-9">
			<input type="text" class="form-control" name="username"
				data-bv-message="The username is not valid"

				data-bv-notempty="true"
				data-bv-notempty-message="The username is required and cannot be empty"

				data-bv-regexp="true"
				data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
				data-bv-regexp-message="The username can only consist of alphabetical, number, dot and underscore"

				data-bv-stringlength="true"
				data-bv-stringlength-min="6"
				data-bv-stringlength-max="30"
				data-bv-stringlength-message="The username must be more than 6 and less than 30 characters long"

			 />
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-3 control-label">Email address</label>
		<div class="col-sm-9">
			<input class="form-control" name="email" type="email"
				data-bv-emailaddress="true"
				data-bv-emailaddress-message="The input is not a valid email address" />
		</div>
	</div>
			
	
		<div class="form-group">
		<div class="col-xs-12">
		 <button type="submit" class="btn bg-primary btn-block"><i class="fa fa-envelope"></i> Recovery Password</button>  
		 </div>
	
		</div>
		<div class="form-group">
		<div class="col-xs-12"><span class="label label-warning">Note</span> An email will be sent to you E-Mail address with a RESET PASSWORD LINK inside it. Open that Link and the website will give a new Password.
		
		</div>
		</div>
		<div class="form-group">
			<div class="col-xs-12">
				 <a href="/login">
					<i class="fa fa-arrow-circle-right"></i>
					 Login Page
				 </a>
			</div>
			<div class="col-xs-12">     
			<a href="/register" class="text-center"><i class="fa fa-arrow-circle-right"></i> Register a new membership</a>
			</div>	
		</div>
	</form>
					
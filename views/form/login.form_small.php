 <form action="/login" id="loginFormSmall" class="form-horizontal" method="post"
					data-bv-message="This value is not valid"
					data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
					data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
					data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">	
					
	  <div class="input-group">
			<span class="input-group-addon"><i class="fa fa-user"></i></span>
			  <label for="userid" class="sr-only">Email address</label>
			<input class="form-control" placeholder="Email Address" type="text" name="userid" id="userid" required autofocus>
      </div>	
	   <div class="input-group">
			<span class="input-group-addon"><i class="fa fa-key"></i></span>
			  <label for="password" class="sr-only">Password</label>
			<input class="form-control"  name="password" id="password" placeholder="Password" type="password">
      </div>	  
 
		<?PHP 
			foreach(@Constants::$INFO as $srv => $s) {
				echo '<input type="hidden" name="server[]" checked="checked" value="'.$srv.'" />';							
			}
		?>
			
        <div class="checkbox hidden" >
          <label>
            <input type="checkbox" checked="checked" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-sm btn-primary btn-block" type="submit">Sign in</button>
      </form>
	
	  <div class="row">
	  	<div class="col-sm-6 shList">
						 <a href="/forgotpass" class="sh">
							<i class="fa fa-arrow-circle-right"></i>
							 Forgot Pass?
						</a>
		</div>
		<div class="col-sm-6 shList"  >     
                    <a href="/register"  class="sh"><i class="fa fa-arrow-circle-right"></i> Create Account</a>
		</div>
		</div>
 
					
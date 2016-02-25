<div class="jumbotron jumbo-login">
  <div class="container">
	<div class="form-box animated bounceIn" id="login-box">
            <div class="header bg-teal">Sign In</div>          
                <div class="body bg-trans">
					<?PHP if (@$message) {
								foreach($message as $msg => $m) {
								echo '<div class="alert alert-warning">'.$m.'</div>';
								}
						  echo '<br/>';
						  }
					?>
				 <?php include('form/login.form.php'); ?>
                </div>
                <div class="footer bg-trans">                   
                   
                </div>
           

         
        </div>
  </div>
</div>


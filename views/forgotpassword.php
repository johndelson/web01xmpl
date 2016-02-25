<div class="jumbotron jumbo-login">
  <div class="container">
	<div class="form-box lostpass-box animated bounceIn" id="login-box">
            <div class="header bg-orange">Forgot Password</div>          
                <div class="body bg-trans">
					<?PHP if (@$message)								
								echo '<div class="alert alert-warning">'.$message.'</div><br/>';
							
					?>
				 <?php include('form/forgotpassword.form.php'); ?>
                </div>
                <div class="footer bg-trans">    
                </div>
           

         
        </div>
  </div>
</div>


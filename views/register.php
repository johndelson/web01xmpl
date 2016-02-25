<div class="jumbotron jumbo-register">
  <div class="container">
	<div class="form-box register-box  animated bounceInUp" id="login-box">
            <div class="header">Register New Membership</div>
			<?PHP if (@$message) echo '<div class="alert alert-warning">'.$message.'</div>'; ?>
			<?PHP if (@!$code || $code == 500): ?>		
			<div class="body bg-trans">
			
			
		
			
            <?PHP include('form/register.form.php'); ?>
			
			
			</div>
            <div class="footer bg-trans col-xs-12">   
			
				<label class="col-sm-3 control-label"></label>
				<div class="col-sm-5">			
                <a href="/login" class="text-center"><i class="fa fa-arrow-circle-right"></i> I already have a membership</a>
				</div> 
            </div>           

			<?PHP endif; ?>
        </div>
  </div>
</div>

 <form action="/login" id="loginForm" class="form-horizontal" method="post"
					data-bv-message="This value is not valid"
					data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
					data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
					data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">		
					<div class="form-group">
						<label class="col-md-3 control-label">Username</label>
						<div class="col-md-9">					
                        <input name="userid" class="form-control" type="text"
								data-bv-message="The username is not valid"

								data-bv-notempty="true"
								data-bv-notempty-message="The username is required and cannot be empty"

								data-bv-regexp="true"
								data-bv-regexp-regexp="[a-zA-Z0-9]+"
								data-bv-regexp-message="The username can only consist of alphabetical and number only"
								
								data-bv-stringlength="true"
								data-bv-stringlength-min="4"
								data-bv-stringlength-max="30"
								data-bv-stringlength-message="The input is not a valid Username" />
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label">Password</label>
						<div class="col-md-9">
                        <input name="password" class="form-control" type="password"
								data-bv-notempty="true"
								data-bv-notempty-message="The password is required and cannot be empty" 
								
								data-bv-stringlength="true"
								data-bv-stringlength-min="4"
								data-bv-stringlength-max="20"
								data-bv-stringlength-message="The input is not a valid Password"/>
                    </div>   
					</div>					
                    <div class="form-group">						
						
						<?PHP					
	
							if ($body != 'login.php') {
								foreach(@$Server as $srv => $s) {
									echo '<input type="hidden" name="server[]" checked="checked" value="'.$srv.'" />';							
								}
							} else {
								echo '<label class="col-md-3 control-label">Servers</label>
									  <div class="col-md-9">';
							
								foreach(@$serverlist as $srv => $s) {
									echo '<div class="checkbox">
											<label>
												<input type="checkbox" name="server[]" checked="checked" value="'.$srv.'"
													data-bv-message="Please Select a Server"
													data-bv-notempty="true" /> '.$s[1].' (<small>'.$s[0].'</small>)
											</label>
										</div>';
								
								}
							echo '	</div>';
							}
						?>	
					
					</div>
					<div class="form-group">
					<div class="col-xs-12">
					 <button type="submit" class="btn bg-primary btn-block"><i class="fa fa-sign-in"></i> Login</button>  
					 </div>
				
					</div>
					<div class="form-group">
					 <div class="col-xs-12">
						 <a href="/forgotpass">
							<i class="fa fa-arrow-circle-right"></i>
							 I forgot my password
						</a>
					</div>
					     	 <div class="col-xs-12">     
                    <a href="/register" class="text-center"><i class="fa fa-arrow-circle-right"></i> Register a new membership</a>
					</div>	</div>
				</form>
					
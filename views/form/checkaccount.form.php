

<form id="giftItem" 
	data-sid="<?PHP echo Constants::$V['sid']; ?>"
	data-action="giftCharacterName"
	data-bv-message="This value is not valid"
	data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
	data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
	data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
	role="form" autocomplete="off">
	<div class="form-group">
			<label>Character Name</label>
			<input class="form-control" name="GiftAccount" placeholder="Enter ..." type="text"	
				data-bv-message="The Character is not valid"

                data-bv-notempty="true"
                data-bv-notempty-message="The Character Name is required and cannot be empty"
	
				data-bv-notempty="true"
                data-bv-notempty-message="The Character Name is required and cannot be empty"
				
                data-bv-regexp="true"
                data-bv-regexp-regexp="[a-zA-Z0-9_\.]+"
                data-bv-regexp-message="The Character can only consist of alphabetical, number, dot and underscore"

                data-bv-stringlength="true"
                data-bv-stringlength-min="6"
                data-bv-stringlength-max="30"
                data-bv-stringlength-message="The Character must be more than 6 and less than 30 characters long"

               
			/>
		</div>
	<div class="form-group">
		<label>Server</label>
		<input type="text" class="form-control" disabled value="<?PHP echo Constants::$V['name']; ?>" name="sid" />
	</div>
	<div class="form-group">
		<label>Item to Send</label>
		<input type="text"  class="form-control" disabled value="<?PHP echo $title; ?>" name="title" />
		<input type="hidden"  class="form-control" value="<?PHP echo $id; ?>" name="id" />
	</div>
	
	  <button type="submit" class="btn btn-go btn-primary">Send my Gift!</button>
</form>
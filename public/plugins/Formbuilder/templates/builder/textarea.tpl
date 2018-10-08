<li id="{fbid}" class="frmb-group">
	<div class="row">
		<div class="col-xs-12"><h4>{label}</h4></div>
	</div>	
	<div class="row">
		<div class="form-group col-xs-9">
			<label for="{fbid}_label">Question:</label>
			<textarea class="form-control" value="{model.label}" rows="3" placeholder="ex: A long question..." name="{fbid}_label" id="{fbid}_label" required>
			</textarea>

		</div>
		<div class="form-group col-xs-3">
			<label for="{fbid}_required">Required?</label>
			<input type="checkbox" value="1" {?model.required}checked="checked"{/model.required} name="{fbid}_required" id="{fbid}_required">
			<a href="#" class="frmb-remove text-danger"><strong>Remove</strong></a>
		</div>
	</div>

</li>
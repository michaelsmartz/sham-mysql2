<li id="{fbid}" class="frmb-group">
	<div class="row">
		<div class="col-md-12">
			<h5>{label} <a style="float:right;padding-right: 15px;" href="#" class="frmb-remove text-danger"><strong>Remove</strong></a></h5>
			<div class="hide text-right">
				<a style="padding-right: 15px;" href="#" class="frmb-remove text-danger"><strong>Remove</strong></a>
			</div>
		</div>
		<div class="hide form-group col-md-3 text-right">
			<div style="display: none">
				<label for="{fbid}_required">Required?</label>
				<input type="checkbox" value="1" {?model.required}checked="checked"{/model.required} name="{fbid}_required" id="{fbid}_required">
			</div>
		</div>
	</div>	
	<div class="row">
		<label for="{label}_label" style="margin-left: 20px;">Question:</label> <br>
		<div class="form-group col-md-10">
			<input type="text" class="form-control question" autocomplete="off" value="{model.label}" placeholder="ex: First Name" 
				   name="{fbid}_label" id="{fbid}_label" required data-parsley-required="true" data-parsley-minlength="5">
		</div>
		<div class="form-group col-md-2">
			<label for="" style="float:left;vertical-align:middle;">Points: </label>
			<input type="text" class="form-control points" style="margin-left:5px; float:left; width:41%;" value="{model.Points}" placeholder="10" name="{fbid}_Points" id="{fbid}_Points"
				   data-parsley-required="true" data-parsley-type="digits" 
				   data-parsley-min="1" data-parsley-min-message="Minimum points value: 1">
		</div>
	</div>
	{?allowsChoices}
	<a href="#" class="frmb-add-choice text-success" style="width:85px"><strong>Add Choice</strong></a>
	<div id="parsley-id-multiple-{fbid}"></div>

	<ul class="frmb-choices">
	</ul>
	{/allowsChoices}
</li>
<li id="{fbid}" class="frmb-choice-group">
	<div class="row">
		<div class="form-group col-md-12" style="margin-bottom:5px">
			<div class="col-md-7">
				<label for="{fbid}.label">Choice</label>
			</div>
			<div class="col-md-5">
				<div class="text-right">
					<label for="{fbid}.selected">Mark as correct answer? </label>
					<input type="checkbox" value="1" {?model.selected}checked="checked"{/model.selected} name="{fbid}.selected" id="{fbid}.selected">
					<a href="#" class="frmb-choice-remove text-danger"><strong>Remove</strong></a>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-10">
			<input type="text" class="form-control" value="{model.label}" placeholder="ex: Red" name="{fbid}.label" id="{fbid}.label">
		</div>
		<div class="col-md-2">
			<label for="{fbid}.Points" style="float:left;vertical-align:middle;">Points </label>
			<input type="text" class="form-control" style="float:left; width:40%;" value="{model.Points}" placeholder="10" name="{fbid}.Points" id="{fbid}.Points">
		</div>
	</div>
</li>
<li id="{fbid}" class="frmb-choice-group">
	<div class="row">
		<div class="form-group col-md-12" style="margin-bottom:5px">
			<div class="col-md-6">
				<label for="">Choice:</label>
			</div>
			<div class="col-md-4 text-right" style="padding-right: 0">
				<label for="{fbid}.selected">Mark as correct answer? </label>
				<input type="checkbox" class="choicecorrect" 
					   data-parsley-mincheck="1" data-parsley-maxcheck="1" 
					   data-parsley-validate-if-empty="" 
					   data-parsley-multiple="{parentFbid}" 
					   data-parsley-group="{parentFbid}" 
					   data-parsley-errors-container="#parsley-id-multiple-{parentFbid}" 
					   value="1" {?model.selected}checked="checked"{/model.selected} name="{fbid}.selected" id="{fbid}.selected" style="margin-right: 0">
			</div>
			<div class="col-md-2 text-right">
				<a href="#" class="frmb-choice-remove text-danger"><strong>Remove</strong></a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-10">
			<input type="text" class="form-control choicequestion" value="{model.label}" placeholder="ex: Red" 
				   data-parsley-required="true" data-parsley-minlength="1" 
				   name="{fbid}.label" id="{fbid}.label">
		</div>
		<div class="col-md-2">
			<label for="" style="float:left;vertical-align:middle;">Points:</label>
			<input type="text" class="form-control choicepoints" style="margin-left:5px; float:left; width:41%;" value="{model.Points}" placeholder="0" readonly name="{fbid}.Points" id="{fbid}.Points">
		</div>
	</div>
</li>
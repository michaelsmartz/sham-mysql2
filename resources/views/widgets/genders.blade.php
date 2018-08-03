<div class="row">
	<div class="col-xs-10">
		<div class="form-group">
			{!! Form::label('Genders',' Genders:') !!}
			{!! Form::text('Genders', null,
                ['autocomplete'=>'off', 'class'=>'data-tag-editor', 'data-value'=> $genders]) !!}
		</div>
    </div>
</div>
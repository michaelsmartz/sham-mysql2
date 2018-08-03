<div class="row">
	<div class="col-xs-10">
		<div class="form-group">
			{!! Form::label('Languages',' Languages:') !!}
			{!! Form::text('Languages', null,
                ['autocomplete'=>'off', 'class'=>'data-tag-editor', 'data-value'=> $languages]) !!}
		</div>
    </div>
</div>
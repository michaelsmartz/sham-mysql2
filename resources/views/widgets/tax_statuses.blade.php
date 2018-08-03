<div class="row">
	<div class="col-xs-10">
		<div class="form-group">
			{!! Form::label('taxstatuses',' Tax Statuses:') !!}
			{!! Form::text('Tax Statuses', null,
                ['autocomplete'=>'off', 'class'=>'data-tag-editor', 'data-value'=> $taxstatuses]) !!}
		</div>
    </div>
</div>
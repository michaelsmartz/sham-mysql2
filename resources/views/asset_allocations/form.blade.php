{!! Form::hidden('redirectsTo', URL::previous()) !!}
<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('asset_id') ? 'has-error' : '' }}">
    <label for="asset_id">Asset Tag</label>
        @if(isset($assetEmployee->asset_id))
        <input type="hidden" name="asset_id" value="{{$assetEmployee->asset_id}}">
        @endif
        <select class="form-control" id="asset_id" name="asset_id" {!! optional($assetEmployee)->asset_id != '' ? 'disabled="disabled"' : 'required="true"' !!}>
        	    <option value="" style="display: none;" {{ old('asset_id', optional($assetEmployee)->asset_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select asset tag</option>
        	@foreach ($assets as $key => $asset)
			    <option value="{{ $key }}" {{ old('asset_id', optional($assetEmployee)->asset_id) == $key ? 'selected' : '' }}>
			    	{{ $asset }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('asset_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('employee_id') ? 'has-error' : '' }}">
    <label for="employee_id">Employee</label>
        @if(isset($assetEmployee->employee_id))
        <input type="hidden" name="employee_id" value="{{$assetEmployee->employee_id}}">
        @endif
        <select class="form-control" id="employee_id" name="employee_id" {!! optional($assetEmployee)->employee_id != '' ? 'disabled="disabled"' : 'required="true"' !!}>
        	    <option value="" style="display: none;" {{ old('employee_id', optional($assetEmployee)->employee_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select employee</option>
        	@foreach ($employees as $key => $employee)
			    <option value="{{ $key }}" {{ old('employee_id', optional($assetEmployee)->employee_id) == $key ? 'selected' : '' }}>
			    	{{ $employee }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('employee_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('date_out') ? 'has-error' : '' }}">
    <label for="date_out">Date Out</label>
        <input class="form-control datepicker" name="date_out" type="text" id="date_out" value="{{ old('date_out', optional($assetEmployee)->date_out) }}" required="true" data-pair-element-id="date_in" autocomplete="off" placeholder="Enter date out">
        {!! $errors->first('date_out', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('date_in') ? 'has-error' : '' }}">
    <label for="date_in">Date In</label>
        <input class="form-control datepicker" name="date_in" type="text" id="date_in" value="{{ old('date_in', optional($assetEmployee)->date_in) }}" data-min-date="{{ old('date_out', optional($assetEmployee)->date_out) }}" autocomplete="off" placeholder="Enter date in">
        {!! $errors->first('date_in', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('comment') ? 'has-error' : '' }}">
    <label for="comment">Comment</label>
        <input class="form-control" name="comment" type="text" id="comment" value="{{ old('comment', optional($assetEmployee)->comment) }}" maxlength="1024" placeholder="Enter comment">
        {!! $errors->first('comment', '<p class="help-block">:message</p>') !!}
</div>
<div id="date-picker"> </div>
</div>
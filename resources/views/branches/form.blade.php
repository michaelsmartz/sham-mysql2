<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('company_id') ? 'has-error' : '' }}">
    <label for="company_id">Company</label>
        <select class="form-control" id="company_id" name="company_id" required="true">
        	    <option value="" style="display: none;" {{ old('company_id', optional($branch)->company_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select company</option>
        	@foreach ($companies as $key => $company)
			    <option value="{{ $key }}" {{ old('company_id', optional($branch)->company_id) == $key ? 'selected' : '' }}>
			    	{{ $company }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('company_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">Description</label>
        <input class="form-control" name="description" type="text" id="description" value="{{ old('description', optional($branch)->description) }}" minlength="1" maxlength="50" required="true" placeholder="Enter description">
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

</div>
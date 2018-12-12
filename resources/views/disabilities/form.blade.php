<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">Description</label>
        <input class="form-control" name="description" type="text" id="description" value="{{ old('description', optional($disability)->description) }}" minlength="1" maxlength="100" required="true" placeholder="Enter description">
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('disability_category_id') ? 'has-error' : '' }}">
    <label for="disability_category_id">Disability Category</label>
        <select class="form-control" id="disability_category_id" name="disability_category_id" required="true">
        	    <option value="" style="display: none;" {{ old('disability_category_id', optional($disability)->disability_category_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select disability category</option>
        	@foreach ($disabilityCategories as $key => $disabilityCategory)
			    <option value="{{ $key }}" {{ old('disability_category_id', optional($disability)->disability_category_id) == $key ? 'selected' : '' }}>
			    	{{ $disabilityCategory }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('disability_category_id', '<p class="help-block">:message</p>') !!}
</div>

</div>
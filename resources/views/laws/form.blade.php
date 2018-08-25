<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('main_heading') ? 'has-error' : '' }}">
    <label for="main_heading">Main Heading</label>
        <input class="form-control" name="main_heading" type="text" id="main_heading" value="{{ old('main_heading', isset($law->main_heading) ? $law->main_heading : null) }}" minlength="1" maxlength="100" required="true" placeholder="Enter main heading">
        {!! $errors->first('main_heading', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('sub_heading') ? 'has-error' : '' }}">
    <label for="sub_heading">Sub Heading</label>
        <input class="form-control" name="sub_heading" type="text" id="sub_heading" value="{{ old('sub_heading', isset($law->sub_heading) ? $law->sub_heading : null) }}" maxlength="100" placeholder="Enter sub heading">
        {!! $errors->first('sub_heading', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('country_id') ? 'has-error' : '' }}">
    <label for="country_id">Country</label>
        <select class="form-control" id="country_id" name="country_id">
        	    <option value="" style="display: none;" {{ old('country_id', isset($law->country_id) ? $law->country_id : '') == '' ? 'selected' : '' }} disabled selected>Enter country</option>
        	@foreach ($countries as $key => $country)
			    <option value="{{ $key }}" {{ old('country_id', isset($law->country_id) ? $law->country_id : null) == $key ? 'selected' : '' }}>
			    	{{ $country }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('country_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('law_category_id') ? 'has-error' : '' }}">
    <label for="law_category_id">Law Category</label>
        <select class="form-control" id="law_category_id" name="law_category_id">
        	    <option value="" style="display: none;" {{ old('law_category_id', isset($law->law_category_id) ? $law->law_category_id : '') == '' ? 'selected' : '' }} disabled selected>Select law category</option>
        	@foreach ($lawCategories as $key => $lawCategory)
			    <option value="{{ $key }}" {{ old('law_category_id', isset($law->law_category_id) ? $law->law_category_id : null) == $key ? 'selected' : '' }}>
			    	{{ $lawCategory }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('law_category_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('content') ? 'has-error' : '' }}">
    <label for="content">Content</label>
        <textarea class="form-control" name="content" cols="50" rows="5" id="content" minlength="1" maxlength="4294967295" required="true" placeholder="Enter content">{{ old('content', isset($law->content) ? $law->content : null) }}</textarea>
        {!! $errors->first('content', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('is_public') ? 'has-error' : '' }}">
    <label for="is_public">Is Public</label>
        <div class="checkbox">
            <label for="is_public_1">
            	<input id="is_public_1" class="" name="is_public" type="checkbox" value="1" {{ old('is_public', isset($law->is_public) ? $law->is_public : null) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

        {!! $errors->first('is_public', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('expires_on') ? 'has-error' : '' }}">
    <label for="expires_on">Expires On</label>
        <input class="form-control" name="expires_on" type="text" id="expires_on" value="{{ old('expires_on', isset($law->expires_on) ? $law->expires_on : null) }}" placeholder="Enter expires on">
        {!! $errors->first('expires_on', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('expires_on') ? 'has-error' : '' }}">
    <label for="expires_on">Expires On</label>
	@uploader('images')
</div>

</div>

@uploader('assets')
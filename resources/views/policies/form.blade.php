{!! Form::hidden('redirectsTo', URL::previous()) !!}
<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('title') ? 'has-error' : '' }}">
    <label for="title">Title</label>
        <input class="form-control" name="title" type="text" id="title" value="{{ old('title', isset($policy->title) ? $policy->title : null) }}" minlength="1" maxlength="100" required="true" placeholder="Enter title">
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('content') ? 'has-error' : '' }}">
    <label for="content">Content</label>
        <textarea class="form-control" name="content" cols="50" rows="5" id="content" minlength="1" maxlength="4294967295" required="true" placeholder="Enter content">{{ old('content', isset($policy->content) ? $policy->content : null) }}</textarea>
        {!! $errors->first('content', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('policy_category_id') ? 'has-error' : '' }}">
    <label for="policy_category_id">Policy Category</label>
        <select class="form-control" id="policy_category_id" name="policy_category_id">
        	    <option value="" style="display: none;" {{ old('policy_category_id', isset($policy->policy_category_id) ? $policy->policy_category_id : '') == '' ? 'selected' : '' }} disabled selected>Select policy category</option>
        	@foreach ($policyCategories as $key => $policyCategory)
			    <option value="{{ $key }}" {{ old('policy_category_id', isset($policy->policy_category_id) ? $policy->policy_category_id : null) == $key ? 'selected' : '' }}>
			    	{{ $policyCategory }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('policy_category_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('expires_on') ? 'has-error' : '' }}">
    <label for="expires_on">Expires On</label>
        <input class="form-control datepicker" name="expires_on" type="text" id="expires_on" value="{{ old('expires_on', isset($policy->expires_on) ? $policy->expires_on : null) }}" placeholder="Enter expires on">
        {!! $errors->first('expires_on', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('attachment') ? 'has-error' : '' }}">
	@include('partials.uploader',[
        'fieldLabel' => 'Attach Law Document',
        'desc' => 'Upload documents only',
        'route' => 'laws.store',
        'acceptedFiles' => "['doc', 'docx', 'ppt', 'pptx', 'pdf']"
    ])
</div>

</div>
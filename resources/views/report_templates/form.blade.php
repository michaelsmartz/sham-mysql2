<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('source') ? 'has-error' : '' }}">
    <label for="source">Source</label>
        <input class="form-control" name="source" type="text" id="source" value="{{ old('source', optional($reportTemplate)->source) }}" minlength="1" required="true" placeholder="Enter source">
        {!! $errors->first('source', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('title') ? 'has-error' : '' }}">
    <label for="title">Title</label>
        <input class="form-control" name="title" type="text" id="title" value="{{ old('title', optional($reportTemplate)->title) }}" minlength="1" maxlength="50" placeholder="Enter title">
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('system_module_id') ? 'has-error' : '' }}">
    <label for="system_module_id">System Module</label>
        <select class="form-control" id="system_module_id" name="system_module_id">
        	    <option value="" style="display: none;" {{ old('system_module_id', optional($reportTemplate)->system_module_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select System Module</option>
        	@foreach ($system_modules as $key => $system_module)
			    <option value="{{ $key }}" {{ old('system_module_id', optional($reportTemplate)->system_module_id) == $key ? 'selected' : '' }}>
			    	{{ $system_module }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('system_module_id', '<p class="help-block">:message</p>') !!}
</div>

</div>
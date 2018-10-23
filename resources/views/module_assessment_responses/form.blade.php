<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('module_id') ? 'has-error' : '' }}">
    <label for="module_id">Module</label>
        <select class="form-control" id="module_id" name="module_id" required="true">
        	    <option value="" style="display: none;" {{ old('module_id', optional($moduleAssessmentResponse)->module_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select module</option>
        	@foreach ($modules as $key => $module)
			    <option value="{{ $key }}" {{ old('module_id', optional($moduleAssessmentResponse)->module_id) == $key ? 'selected' : '' }}>
			    	{{ $module }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('module_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('employee_id') ? 'has-error' : '' }}">
    <label for="employee_id">Employee</label>
        <select class="form-control" id="employee_id" name="employee_id" required="true">
        	    <option value="" style="display: none;" {{ old('employee_id', optional($moduleAssessmentResponse)->employee_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select employee</option>
        	@foreach ($employees as $key => $employee)
			    <option value="{{ $key }}" {{ old('employee_id', optional($moduleAssessmentResponse)->employee_id) == $key ? 'selected' : '' }}>
			    	{{ $employee }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('employee_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('is_reviewed') ? 'has-error' : '' }}">
    <label for="is_reviewed">Is Reviewed</label>
        <input class="form-control" name="is_reviewed" type="text" id="is_reviewed" value="{{ old('is_reviewed', optional($moduleAssessmentResponse)->is_reviewed) }}">
        {!! $errors->first('is_reviewed', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('module_assessment_id') ? 'has-error' : '' }}">
    <label for="module_assessment_id">Module Assessment</label>
        <select class="form-control" id="module_assessment_id" name="module_assessment_id">
        	    <option value="" style="display: none;" {{ old('module_assessment_id', optional($moduleAssessmentResponse)->module_assessment_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select module assessment</option>
        	@foreach ($moduleAssessments as $key => $moduleAssessment)
			    <option value="{{ $key }}" {{ old('module_assessment_id', optional($moduleAssessmentResponse)->module_assessment_id) == $key ? 'selected' : '' }}>
			    	{{ $moduleAssessment }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('module_assessment_id', '<p class="help-block">:message</p>') !!}
</div>

</div>
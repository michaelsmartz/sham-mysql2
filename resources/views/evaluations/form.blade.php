<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('assessment_id') ? 'has-error' : '' }}">
    <label for="assessment_id">Assessment</label>
        <select class="form-control" id="assessment_id" name="assessment_id" required="true">
        	    <option value="" style="display: none;" {{ old('assessment_id', optional($evaluation)->assessment_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select assessment</option>
        	@foreach ($assessments as $key => $assessment)
			    <option value="{{ $key }}" {{ old('assessment_id', optional($evaluation)->assessment_id) == $key ? 'selected' : '' }}>
			    	{{ $assessment }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('assessment_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('user_employee_id') ? 'has-error' : '' }}">
    <label for="user_employee_id">Employee</label>
        <select class="form-control" id="user_employee_id" name="user_employee_id" required="true">
        	    <option value="" style="display: none;" {{ old('user_employee_id', optional($evaluation)->user_employee_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select user employee</option>
        	@foreach ($employees as $key => $employee)
			    <option value="{{ $key }}" {{ old('user_employee_id', optional($evaluation)->user_employee_id) == $key ? 'selected' : '' }}>
			    	{{ $employee }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('user_employee_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('department_id') ? 'has-error' : '' }}">
    <label for="department_id">Department</label>
        <select class="form-control" id="department_id" name="department_id" required="true">
        	    <option value="" style="display: none;" {{ old('department_id', optional($evaluation)->department_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select department</option>
        	@foreach ($departments as $key => $department)
			    <option value="{{ $key }}" {{ old('department_id', optional($evaluation)->department_id) == $key ? 'selected' : '' }}>
			    	{{ $department }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('department_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('reference_no') ? 'has-error' : '' }}">
    <label for="reference_no">Reference No</label>
        <input class="form-control" name="reference_no" type="text" id="reference_no" value="{{ old('reference_no', optional($evaluation)->reference_no) }}" maxlength="200" placeholder="Enter reference no">
        {!! $errors->first('reference_no', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('reference_source') ? 'has-error' : '' }}">
    <label for="reference_source">Reference Source</label>
        <input class="form-control" name="reference_source" type="text" id="reference_source" value="{{ old('reference_source', optional($evaluation)->reference_source) }}" maxlength="200" placeholder="Enter reference source">
        {!! $errors->first('reference_source', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('productcategory_id') ? 'has-error' : '' }}">
    <label for="productcategory_id">Product category</label>
        <select class="form-control" id="productcategory_id" name="productcategory_id" required="true">
        	    <option value="" style="display: none;" {{ old('productcategory_id', optional($evaluation)->productcategory_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select productcategory</option>
        	@foreach ($productCategories as $key => $productCategory)
			    <option value="{{ $key }}" {{ old('productcategory_id', optional($evaluation)->productcategory_id) == $key ? 'selected' : '' }}>
			    	{{ $productCategory }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('productcategory_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('language_id') ? 'has-error' : '' }}">
    <label for="language_id">Language</label>
        <select class="form-control" id="language_id" name="language_id" required="true">
        	    <option value="" style="display: none;" {{ old('language_id', optional($evaluation)->language_id ?: '') == '' ? 'selected' : '' }} disabled selected>Enter language</option>
        	@foreach ($languages as $key => $language)
			    <option value="{{ $key }}" {{ old('language_id', optional($evaluation)->language_id) == $key ? 'selected' : '' }}>
			    	{{ $language }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('language_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('feedback_date') ? 'has-error' : '' }}">
    <label for="feedback_date">Feedback Date</label>
        <input class="form-control" name="feedback_date" type="text" id="feedback_date" value="{{ old('feedback_date', optional($evaluation)->feedback_date) }}" minlength="1" required="true" placeholder="Enter feedback date">
        {!! $errors->first('feedback_date', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('evaluation_status_id') ? 'has-error' : '' }}">
    <label for="evaluation_status_id">Evaluation Status</label>
    <select class="form-control" id="evaluation_status_id" name="evaluation_status_id" required="true">
        <option value="" style="display: none;" {{ old('evaluation_status_id', optional($evaluation)->evaluation_status_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select evaluation status</option>
        @foreach ($evaluationStatuses as $key => $evaluationStatus)
            <option value="{{ $key }}" {{ old('evaluation_status_id', optional($evaluation)->evaluation_status_id) == $key ? 'selected' : '' }}>
                {{ $evaluationStatus }}
            </option>
        @endforeach
    </select>

    {!! $errors->first('evaluation_status_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('qa_sample') ? 'has-error' : '' }}">
    <label for="qa_sample">Qa Sample</label>
        <textarea class="form-control" name="qa_sample" cols="50" rows="1" id="qa_sample" placeholder="Enter qa sample">{{ old('qa_sample', optional($evaluation)->qa_sample) }}</textarea>
        {!! $errors->first('qa_sample', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('comments') ? 'has-error' : '' }}">
    <label for="comments">Comments</label>
        <input class="form-control" name="comments" type="text" id="comments" value="{{ old('comments', optional($evaluation)->comments) }}" maxlength="512" placeholder="Enter comments">
        {!! $errors->first('comments', '<p class="help-block">:message</p>') !!}
</div>

</div>
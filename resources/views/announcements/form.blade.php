<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('title') ? 'has-error' : '' }}">
    <label for="title">Title</label>
        <input class="form-control" name="title" type="text" id="title" value="{{ old('title', optional($announcement)->title) }}" minlength="1" maxlength="50" required="true" placeholder="Enter title">
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">Description</label>
        <textarea class="form-control" name="description" cols="50" rows="5" id="description" minlength="1" maxlength="256" required="true" placeholder="Enter description">{{ old('description', optional($announcement)->description) }}</textarea>
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-4 {{ $errors->has('start_date') ? 'has-error' : '' }}">
    <label for="start_date">Start Date</label>
        <input class="form-control datepicker" name="start_date" type="text" id="start_date" value="{{ old('start_date', optional($announcement)->start_date) }}" minlength="1" required="true" data-pair-element-id="end_date" autocomplete="off" placeholder="Enter start date">
        {!! $errors->first('start_date', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-4 {{ $errors->has('end_date') ? 'has-error' : '' }}">
    <label for="end_date">End Date</label>
        <input class="form-control datepicker" name="end_date" type="text" id="end_date" value="{{ old('end_date', optional($announcement)->end_date) }}" minlength="1" required="true" data-min-date="{{ old('end_date', optional($announcement)->start_date) }}" data-number-of-months="1" autocomplete="off" placeholder="Enter end date">
        {!! $errors->first('end_date', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-4 {{ $errors->has('announcement_status_id') ? 'has-error' : '' }}">
    <label for="announcement_status_id">Status</label>
        <select class="form-control" id="announcement_status_id" name="announcement_status_id" required="true">
        	    <option value="" style="display: none;" {{ old('announcement_status_id', optional($announcement)->announcement_status_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select status</option>
        	@foreach ($announcementStatuses as $key => $announcementStatus)
			    <option value="{{ $key }}" {{ old('announcement_status_id', optional($announcement)->announcement_status_id) == $key ? 'selected' : '' }}>
			    	{{ $announcementStatus }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('announcement_status_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('departments[]') ? 'has-error' : '' }}">
    <label for="from[]">Departments <i class="fa fa-question-circle" data-wenk="Link existing departments" data-wenk-pos="right"></i></label>
</div>

<div class="col-xs-12">
    <div class="flex-wrapper">
        <div class="col-xs-12">
            {!! Form::select('from[]', $departments, null, array('multiple' => 'multiple', 'size' => '10', 'class'=> 'form-control multipleSelect', 'id'=>'multiselect')) !!}
        </div>
    </div>
    <br>
</div>

<div class="col-xs-6 col-xs-offset-3">
    <div class="col-xs-6">
        <button type="button" id="multiselect_rightAll" class="btn btn-block" data-wenk="Select All"><i class="fa fa-angle-double-down" style="font-weight:900"></i></button>
        <button type="button" id="multiselect_rightSelected" class="btn btn-block" data-wenk="Add Selected"><i class="fa fa-angle-down" style="font-weight:900"></i></button>
    </div>
    <div class="col-xs-6">
        <button type="button" id="multiselect_leftSelected" class="btn btn-block" data-wenk="Remove Selected"><i class="fa fa-angle-up" style="font-weight:900"></i></button>
        <button type="button" id="multiselect_leftAll" class="btn btn-block" data-wenk="Unselect All"><i class="fa fa-angle-double-up" style="font-weight:900"></i></button>
    </div>
</div>

<div class="col-xs-12">
    <br>
    <div class="flex-wrapper">
        <div class="col-xs-12">
            {!! Form::select('departments[]', isset($announcementDepartments)?$announcementDepartments:[],null, array('multiple' => 'multiple', 'size' => '10', 'class'=> 'form-control', 'id'=>'multiselect_to')) !!}
        </div>
        {!! $errors->first('departments[]', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div id="date-picker"> </div>

</div>
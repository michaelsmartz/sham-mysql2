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
        <input class="form-control datepicker" name="start_date" type="text" id="start_date" value="{{ old('start_date', optional($announcement)->start_date) }}" minlength="1" required="true" placeholder="Enter start date" data-min-date="0">
        {!! $errors->first('start_date', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-4 {{ $errors->has('end_date') ? 'has-error' : '' }}">
    <label for="end_date">End Date</label>
        <input class="form-control datepicker" name="end_date" type="text" id="end_date" value="{{ old('end_date', optional($announcement)->end_date) }}" minlength="1" required="true" placeholder="Enter end date">
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

</div>
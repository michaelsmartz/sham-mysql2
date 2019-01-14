<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('join-termination') ? 'has-error' : '' }}">
    @if(isset($employeeHistory['is_joined']) && $employeeHistory['is_joined'])
        <label for="name">Join Date</label>
    @else
        <label for="name">Termination Date</label>
    @endif
    <input type="hidden" name="is-joined" value="{{$employeeHistory['is_joined']}}"/>
    <input class="form-control datepicker" name="join-termination" type="text" id="join-termination" value="{{ old('join-termination', $employeeHistory['historyJoinTerminationDate']) }}" placeholder="Enter history join/termination date">
    {!! $errors->first('join-termination', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('department') ? 'has-error' : '' }}">
    <label for="name">Department Date</label>
    <input class="form-control datepicker" name="department" type="text" id="department" value="{{ old('department', $employeeHistory['historyDepartmentDate']) }}" placeholder="Enter history department date">
    {!! $errors->first('department', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('job-title') ? 'has-error' : '' }}">
    <label for="name">Job Titles Date</label>
    <input class="form-control datepicker" name="job-title" type="text" id="job-title" value="{{ old('job-title', $employeeHistory['historyJobTitleDate']) }}" placeholder="Enter history job title">
    {!! $errors->first('job-title', '<p class="help-block">:message</p>') !!}
</div>

<div id="date-picker"> </div>

</div>
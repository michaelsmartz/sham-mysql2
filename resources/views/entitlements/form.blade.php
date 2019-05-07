<div class="row">

<div class="form-group col-xs-12 {{ $errors->has('leave_policy') ? 'has-error' : '' }}">
    <label for="duration_unit">Leave Policy</label>
    <select class="form-control" id="leave_policy" name="leave_policy" required="true">
        <option value="" style="display: none;" {{ old('leave_policy', optional($entitlement)->leave_policy ?: '') == '' ? 'selected' : '' }} disabled selected>Select Leave Policy</option>
        @foreach ($leave_policies as $key => $leave_policy)
            <option value="{{ $key }}" {{ old('leave_policy', optional($entitlement)->leave_policy) == $key ? 'selected' : '' }}>
                {{ $leave_policy }}
            </option>
        @endforeach
    </select>
    {!! $errors->first('leave_policy', '<p class="help-block">:message</p>') !!}
</div>
    
<div class="form-group col-xs-6 {{ $errors->has('start_date') ? 'has-error' : '' }}">
    <label for="start_date">Start Date</label>
        <input class="form-control datepicker" name="start_date" type="text" id="start_date" value="{{ old('start_date', optional($entitlement)->start_date) }}" placeholder="Enter start date here..." required="true">
        {!! $errors->first('start_date', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('end_date') ? 'has-error' : '' }}">
    <label for="end_date">End Date</label>
        <input class="form-control datepicker" name="end_date" type="text" id="end_date" value="{{ old('end_date', optional($entitlement)->end_date) }}" placeholder="Enter end date here..." required="true">
        {!! $errors->first('end_date', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('total') ? 'has-error' : '' }}">
    <label for="total">Total</label>
        <input class="form-control" name="total" type="number" id="total" value="{{ old('total', optional($entitlement)->total) }}" placeholder="Enter total here..." required="true">
        {!! $errors->first('total', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('taken') ? 'has-error' : '' }}">
    <label for="taken">Taken</label>
        <input class="form-control" name="taken" type="number" id="taken" value="{{ old('taken', optional($entitlement)->taken) }}" minlength="1" placeholder="Enter taken here...">
        {!! $errors->first('taken', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('is_manually_adjusted') ? 'has-error' : '' }}">
    <label for="is_manually_adjusted">Is Manually Adjusted</label>
        <div class="checkbox">
            <label for="is_manually_adjusted_1">
            	<input id="is_manually_adjusted_1" class="" name="is_manually_adjusted" type="checkbox" value="1" {{ old('is_manually_adjusted', optional($entitlement)->is_manually_adjusted) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

        {!! $errors->first('is_manually_adjusted', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12">
    <label for="employees">Employees</label>
    {!! Form::select('employees[]', $employees,
        old('employees', isset($eligibility_employees) ? $eligibility_employees : null),
        ['class' => 'form-control select-multiple', 'multiple'=>'multiple']
    ) !!}
</div>

<div id="date-picker"> </div>

</div>

@section('post-body')
    <link href="{{URL::to('/')}}/plugins/sumoselect/sumoselect.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/plugins/sumoselect/jquery.sumoselect.min.js"></script>
    <script>
        $('document').ready(function() {
            $('.select-multiple').SumoSelect({csvDispCount: 10, up: true});
        });
    </script>
@endsection
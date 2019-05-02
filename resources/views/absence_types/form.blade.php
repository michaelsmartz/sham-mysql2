<div class="row">

<div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">Description</label>
        <input class="form-control" name="description" type="text" id="description" value="{{ old('description', optional($absenceType)->description) }}" minlength="1" maxlength="100" required="true" placeholder="Enter description">
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('duration_unit') ? 'has-error' : '' }}">
    <label for="duration_unit">Duration Unit</label>
    <select class="form-control" id="duration_unit" name="duration_unit" required="true">
        <option value="" style="display: none;" {{ old('duration_unit', optional($absenceType)->duration_unit ?: '') == '' ? 'selected' : '' }} disabled selected>Select Duration Unit</option>
        @foreach ($duration_units as $key => $duration_unit)
            <option value="{{ $key }}" {{ old('duration_unit', optional($absenceType)->duration_unit) == $key ? 'selected' : '' }}>
                {{ $duration_unit }}
            </option>
        @endforeach
    </select>
    {!! $errors->first('duration_unit', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('eligibility_begins') ? 'has-error' : '' }}">
    <label for="eligibility_begins">Employee Gains Eligibility</label>
    <select class="form-control" id="eligibility_begins" name="eligibility_begins" required="true">
        <option value="" style="display: none;" {{ old('eligibility_begins', optional($absenceType)->eligibility_begins ?: '') == '' ? 'selected' : '' }} disabled selected>Select Start Of Eligibility</option>
        @foreach ($start_eligibilities as $key => $start_eligibility)
            <option value="{{ $key }}" {{ old('eligibility_begins', optional($absenceType)->eligibility_begins) == $key ? 'selected' : '' }}>
                {{ $start_eligibility }}
            </option>
        @endforeach
    </select>
    {!! $errors->first('eligibility_begins', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('eligibility_ends') ? 'has-error' : '' }}">
    <label for="eligibility_ends">Employee Gains Eligibility</label>
    <select class="form-control" id="eligibility_ends" name="eligibility_ends" required="true">
        <option value="" style="display: none;" {{ old('eligibility_ends', optional($absenceType)->eligibility_ends ?: '') == '' ? 'selected' : '' }} disabled selected>Select End Of Eligibility</option>
        @foreach ($end_eligibilities as $key => $end_eligibility)
            <option value="{{ $key }}" {{ old('eligibility_ends', optional($absenceType)->eligibility_ends) == $key ? 'selected' : '' }}>
                {{ $end_eligibility }}
            </option>
        @endforeach
    </select>
    {!! $errors->first('eligibility_ends', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('amount_earns') ? 'has-error' : '' }}">
    <label for="amount_earns">Amount Earns</label>
        <input class="form-control" name="amount_earns" type="text" id="amount_earns" value="{{ old('amount_earns', optional($absenceType)->amount_earns) }}" placeholder="Enter amount earns">
        {!! $errors->first('amount_earns', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('accrue_period') ? 'has-error' : '' }}">
    <label for="accrue_period">Accrue Period</label>
    <select class="form-control" id="accrue_period" name="accrue_period" required="true">
        <option value="" style="display: none;" {{ old('accrue_period', optional($absenceType)->accrue_period ?: '') == '' ? 'selected' : '' }} disabled selected>Select Accrue Period</option>
        @foreach ($accrue_periods as $key => $accrue_period)
            <option value="{{ $key }}" {{ old('accrue_period', optional($absenceType)->accrue_period) == $key ? 'selected' : '' }}>
                {{ $accrue_period }}
            </option>
        @endforeach
    </select>
    {!! $errors->first('accrue_period', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12">
    <label for="jobTitles">Apply To</label>
    {!! Form::select('jobTitles[]', $jobTitles,
        old('jobTitles', isset($absenceTypeJobTitles) ? $absenceTypeJobTitles : null),
        ['class' => 'form-control select-multiple', 'multiple'=>'multiple']
    ) !!}
</div>

</div>

@section('post-body')
    <link href="{{URL::to('/')}}/plugins/sumoselect/sumoselect.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/plugins/sumoselect/jquery.sumoselect.min.js"></script>
    <script>
        $('.select-multiple').SumoSelect({csvDispCount: 10, up: true});
    </script>
@endsection
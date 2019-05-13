<div class="row">

<div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">Description</label>
    <input class="form-control" name="description" type="text" id="description" value="{{ old('description', optional($absenceType)->description) }}" minlength="1" maxlength="100" required="true" placeholder="Enter description">
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('duration_unit') ? 'has-error' : '' }}">
    <label for="duration_unit">Duration Unit
        <span>
            <i class="fa fa-question-circle" aria-hidden="true"  data-wenk-pos="right"
               data-wenk="The basic unit to calculate absence.

You need to decide which unit you

would like to use:

Hours - it also can be displayed as days

according to 'Time Shift' hours grid.

Days - entitlement of this absence type

will be calculated only in days

(or 1/2, 1/4, of day, etc.)">
            </i>
        </span>
    </label>
    <select class="form-control" id="duration_unit" name="duration_unit" required="true" {!! ($mode =='edit')?'disabled':'' !!}>
        <option value="" style="display: none;" {{ old('duration_unit', optional($absenceType)->duration_unit ?: '') == '' ? 'selected' : '' }} disabled selected>Select Duration Unit</option>
        @foreach ($duration_units as $key => $duration_unit)
            <option value="{{ $key }}" {{ old('duration_unit', optional($absenceType)->duration_unit) == $key ? 'selected' : '' }} {!! ($mode =='edit')?'disabled':'' !!}>
                {{ $duration_unit }}
            </option>
        @endforeach
    </select>
    {!! $errors->first('duration_unit', '<p class="help-block">:message</p>') !!}
</div>

@if($mode == 'edit')
<h3 style="margin-left:15px">Accrual Rules</h3>
    <div class="form-group col-xs-6 {{ $errors->has('eligibility_begins') ? 'has-error' : '' }}">
        <label for="eligibility_begins">Employee Gains Eligibility
            <span>
            <i class="fa fa-question-circle" aria-hidden="true"  data-wenk-pos="right"
               data-wenk="Is the starting date when the employee

is allowed to earn the entitlement.

First day at work - it means from

hire date (the day is included)

After probation period - it means

the first date following the

end of probation period">
            </i>
            </span>
        </label>
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
        <label for="eligibility_ends">Employee Loses Eligibility
            <span >
            <i class="fa fa-question-circle" aria-hidden="true"  data-wenk-pos="left"
               data-wenk="Is the day when the employee is

no longer allowed to earn the entitlement.

By default it's the last day of the working

year, but you can also choose:

After probation ends - it means the first

date following the end of probation period">
            </i>
            </span>
        </label>
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

    <div class="form-group col-xs-12" style="margin-bottom: 0px;!important;">
        <div class="col-xs-3" style="margin-top: 15px;  padding-left: 0;">Employee earns</div>
        <div class="form-group col-xs-3 {{ $errors->has('amount_earns') ? 'has-error' : '' }}" style="margin-top: 10px;">

            <input class="form-control" name="amount_earns" type="number" id="amount_earns" min="0" style="" value="{{ old('amount_earns', optional($absenceType)->amount_earns) }}" placeholder="Enter amount earns" required="true">
            {!! $errors->first('amount_earns', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-xs-6" style="margin-top: 15px;">{!! App\Enums\LeaveDurationUnitType::getDescription($absenceType->duration_unit) !!} when the period begins</div class="col-xs-4 center-block text-center">
    </div>

    <div class="form-group col-xs-12 {{ $errors->has('accrue_period') ? 'has-error' : '' }}">
        <label for="accrue_period">Accrue Period
            <span>
            <i class="fa fa-question-circle" aria-hidden="true"  data-wenk-pos="right"
               data-wenk="You can choose a single

accrual or a cyclic accrual.

Monthly, annually..Those types

give you a possibility to give

your employees entitlement in

shorter cycles than a year or

an accrual period that spans

over more than a year.">
            </i>
            </span>
        </label>
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
        <label for="jobTitles">Apply To
            <span>
            <i class="fa fa-question-circle" aria-hidden="true"  data-wenk-pos="right"
               data-wenk="If no employee selected it

will apply to all employee">
            </i>
            </span>
        </label>
        {!! Form::select('jobTitles[]', $jobTitles,
            old('jobTitles', isset($absenceTypeJobTitles) ? $absenceTypeJobTitles : null),
            ['class' => 'form-control select-multiple', 'multiple'=>'multiple']
        ) !!}
    </div>
@endif

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
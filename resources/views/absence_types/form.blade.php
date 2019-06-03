<div class="row">

<div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">Description</label>
    <input class="form-control" name="description" type="text" id="description" value="{{ old('description', optional($absenceType)->description) }}"
           minlength="1" maxlength="100" required="true" placeholder="Enter description"
           pattern = '^[a-zA-ZÀ-ÖØ-öø-ÿ\-]+( [a-zA-ZÀ-ÖØ-öø-ÿ]+)*$'
    >
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
            @foreach ($end_eligibilities as $key => $end_eligibility)
                <option value="{{ $key }}" {{ old('eligibility_ends', optional($absenceType)->eligibility_ends) == $key ? 'selected' : '' }}  {{($hideEndProbation)?"hidden=true":""}}>
                    {{ $end_eligibility }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('eligibility_ends', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-12" style="margin-bottom: 0px;!important;">
        <div class="col-xs-3" style="margin-top: 15px;  padding-left: 0;padding-right: 0;">Employee earns a <b>total</b> of</div>
        <div class="form-group col-xs-3 {{ $errors->has('amount_earns') ? 'has-error' : '' }}" style="margin-top: 10px;">
            {{-- 2 years in hours is equal to 17520 so value cannot exceed this max value --}}
            <input class="form-control" name="amount_earns" type="number"
                   id="amount_earns" min="0" step="0.01" max="17520"
                   value="{{ old('amount_earns', optional($absenceType)->amount_earns) }}"
                   placeholder="Enter total" required="true"
                   oninput="(this.value == 0)?this.setCustomValidity('Total cannot be zero.'):this.setCustomValidity('')">
            {!! $errors->first('amount_earns', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-xs-6" style="margin-top: 15px;"><b>{!! App\Enums\LeaveDurationUnitType::getDescription($absenceType->duration_unit) !!}</b> at the start of accrue period below</div>
    </div>

    <div id="accrue_period"
         class="form-group col-xs-12
                {{ $errors->has('accrue_period') ? 'has-error' : '' }}" {{($hideAccrue)?"hidden=true":""}}>
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
            <option value="{{ -1 }}" {{ old('accrue_period', optional($absenceType)->accrue_period) == -1 ? 'selected' : '' }} hidden="true">{{ $notApplicable }}</option>
            @foreach ($accrue_periods as $key => $accrue_period)
                <option value="{{ $key }}" {{ old('accrue_period', optional($absenceType)->accrue_period) == $key ? 'selected' : '' }}>
                    {{ $accrue_period }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('accrue_period', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-12 job_titles">
        <label for="jobTitles">Apply To
            <span>
            <i class="fa fa-question-circle" aria-hidden="true"  data-wenk-pos="right"
               data-wenk="If no job title selected it

will apply to all job titles">
            </i>
            </span>
        </label>
        {!! Form::select('jobTitles[]', $jobTitles,
            old('jobTitles', isset($absenceTypeJobTitles) ? $absenceTypeJobTitles : null),
            ['class' => 'form-control select-multiple', 'multiple'=>'multiple']
        ) !!}
    </div>
    <div class="form-group col-xs-12 {{ $errors->has('non_working_days') ? 'has-error' : '' }}">
        <label for="non_working_days">Include non-working days</label>
        <div class="checkbox">
            <label for="non_working_days_1">
                <input id="non_working_days_1" class="" name="non_working_days" type="hidden" value="0" />
                <input id="non_working_days_1" class="" name="non_working_days" type="checkbox" value="1" {{ old('is_weekend', optional($absenceType)->non_working_days) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

        {!! $errors->first('non_working_days', '<p class="help-block">:message</p>') !!}
    </div>
@endif
</div>
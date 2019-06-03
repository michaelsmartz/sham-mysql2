@if(isset($leave_id))
    <input type="hidden" value="{{$leave_id}}" id="absence_type_id" name="absence_type_id">
@endif

@if(isset($monthly_allowance))
    <input type="hidden" value="{{$monthly_allowance}}" id="monthly_allowance" name="monthly_allowance">
@endif

@if(isset($non_working))
    <input type="hidden" value="{{$non_working}}" id="non_working" name="non_working">
@endif

@if(isset($employee_id))
   <input type="hidden" id="employee_id" name="employee_id" value="{{$employee_id}}">
@endif

@if(isset($remaining))
    <input id="remaining_balance" name="remaining_balance" type="hidden" value="{{$remaining}}">
    <input id="duration_unit" name="duration_unit" type="hidden" value="{{$duration_unit}}">
@endif

<div class="row">
    <div class="form-group col-sm-6">
        <label class="control-label">From</label>
        <div class="">
            <span class="field">
                {!! Form::text('leave_from', '', ['class'=>'form-control datepicker-leave', 'autocomplete'=>'off','data-date-format'=> "Y-m-d H:i", 'data-enable-time'=> "true",  'placeholder'=>'Starts at', 'id'=>'leave_from','required' ]) !!}
            </span>
        </div>
    </div>

    <div class="form-group col-sm-6">
        <label class="control-label">To</label>
        <div class="">
           <span class="field">
                {!! Form::text('leave_to', '', ['class'=>'form-control datepicker-leave','data-date-format'=> "Y-m-d H:i", 'data-enable-time'=> "true", 'autocomplete'=>'off', 'placeholder'=>'Ends at', 'id'=>'leave_to','required']) !!}
            </span>
        </div>
    </div>
</div>
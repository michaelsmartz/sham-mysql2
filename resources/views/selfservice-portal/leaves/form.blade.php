@if(isset($leave_id))
    <input type="hidden" value="{{$leave_id}}" id="absence_type_id" name="absence_type_id">
@endif

<div class="row">
    <div class="form-group col-sm-6">
        <label class="control-label">From</label>
        <div class="">
            <span class="field">
                {!! Form::text('leave_from', '', ['class'=>'form-control datepicker-leave', 'autocomplete'=>'off','data-date-format'=> "Y-m-d H:i", 'data-min-time'=>$time_period['Monday']['start_time'], 'data-max-time'=>$time_period['Monday']['end_time'], 'data-enable-time'=> "true",  'placeholder'=>'Starts at', 'id'=>'leave_from','required' ]) !!}
            </span>
        </div>
    </div>

    <div class="form-group col-sm-6">
        <label class="control-label">To</label>
        <div class="">
           <span class="field">
                {!! Form::text('leave_to', '', ['class'=>'form-control datepicker-leave','data-date-format'=> "Y-m-d H:i", 'data-enable-time'=> "true", 'data-min-time'=>'9:00', 'data-max-time'=>'17:00', 'autocomplete'=>'off', 'placeholder'=>'Ends at', 'id'=>'leave_to','required']) !!}
            </span>
        </div>
    </div>
</div>
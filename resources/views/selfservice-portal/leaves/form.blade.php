@if(isset($leave_id))
    <input type="hidden" value="{{$leave_id}}" id="absence_type_id" name="absence_type_id">
@endif

<div class="row">
    <div class="form-group col-sm-6">
        <label class="control-label">From</label>
        <div class="">
            <span class="field">
                {!! Form::text('leave_from', '', ['class'=>'form-control datepicker', 'autocomplete'=>'off','data-date-format'=> "Y-m-d H:i", 'data-enable-time'=> "true",  'placeholder'=>'Starts at', 'id'=>'leave_from' ]) !!}
            </span>
        </div>
    </div>

    <div class="form-group col-sm-6">
        <label class="control-label">To</label>
        <div class="">
           <span class="field">
                {!! Form::text('leave_to', '', ['class'=>'form-control datepicker','data-date-format'=> "Y-m-d H:i", 'data-enable-time'=> "true",'autocomplete'=>'off', 'placeholder'=>'Ends at', 'id'=>'leave_to']) !!}
            </span>
        </div>
    </div>
</div>
@if(isset($leave_id))
    <input type="hidden" value="{{$leave_id}}" id="absence_type_id" name="absence_type_id">
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
        <label class="control-label"><i class="glyphicon glyphicon-calendar"></i> From</label>
        <div class="">
            <span class="field">
                {!! Form::text('leave_from', '', ['class'=>'form-control datepicker-leave', 'autocomplete'=>'off','data-min-date'=> $working_year_start,'data-max-date'=> $working_year_end,'data-date-format'=> "Y-m-d H:i", 'data-enable-time'=> "true",  'placeholder'=>'Starts at', 'id'=>'leave_from','required' ]) !!}
            </span>
        </div>
    </div>

    <div class="form-group col-sm-6">
        <label class="control-label"><i class="glyphicon glyphicon-calendar"></i> To</label>
        <div class="">
           <span class="field">
                {!! Form::text('leave_to', '', ['class'=>'form-control datepicker-leave','data-date-format'=> "Y-m-d H:i",'data-min-date'=> $working_year_start,'data-max-date'=> $working_year_end, 'data-enable-time'=> "true", 'autocomplete'=>'off', 'placeholder'=>'Ends at', 'id'=>'leave_to','required']) !!}
            </span>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-12 {{ $errors->has('attachment') ? 'has-error' : '' }}">
    @include('partials.uploader')
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-12">
        <div class="md-form">
            <i class="glyphicon glyphicon-pencil"></i><label for="comments"> Comments</label>
            <textarea id="comments" name="comments" class="md-textarea form-control" rows="3"></textarea>
        </div>
    </div>
</div>
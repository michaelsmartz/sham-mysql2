@extends('portal-index')
@section('title','System Configuration')
@section('content')
    <br>
    <ul class="nav nav-tabs">
        <li><a href="{{URL::to('/')}}/users">Users</a></li>
        <li><a href="{{URL::to('/')}}/sham_user_profiles">User Profiles</a></li>
        <li class="active"><a href="{{URL::to('/')}}/general_options">General Options</a></li>
    </ul>
    <br>
    <form method="POST" action="{{ route('general_options.store') }}" id="general_update_form" name="general_update_form" data-parsley-validate="" accept-charset="UTF-8">
    <div class="form-group col-sm-6">
        <label class="control-label">Working Year Start</label>
        <div class="">
                    <span class="field">
                        {!! Form::text('working_year_start', old('working_year_start', $working_year_start), ['class'=>'form-control datepicker', 'placeholder'=>'Working Year Start', 'id'=>'WorkingYearStart', 'data-pair-element-id'=>'WorkingYearStart' ]) !!}
                    </span>
        </div>
    </div>
    <div class="form-group col-sm-6">
        <label class="control-label">Working Year End</label>
        <div class="">
                   <span class="field">
                        {!! Form::text('working_year_end', old('date_joined', $working_year_end), ['class'=>'form-control datepicker', 'placeholder'=>'Working Year End', 'id'=>'WorkingYearEnd', 'data-pair-element-id'=>'WorkingYearEnd' ]) !!}
                    </span>
        </div>
    </div>
        <div class="row">
            <div class="col-sm-12 text-right">
                <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Update</button>
            </div>
        </div>
    </form>
@endsection
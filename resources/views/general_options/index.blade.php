@extends('portal-index')
@section('title','System Configuration')
<div class="alert-container">
    @if ($errors->any())
        <div class="alert error" role="alert">
            <input type="checkbox" id="alert1"/>
            <label class="close" title="close" for="alert1">
                <i class="fa fa-times"></i>
            </label>

            @foreach ($errors->all() as $error)
                <p class="inner">{{ $error }}</p>
            @endforeach
        </div>
    @endif
</div>
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
                        {!! Form::text('working_year_start', old('working_year_start', $working_year_start), ['class'=>'form-control datepicker', 'autocomplete'=>'off',  'placeholder'=>'Working Year Start', 'id'=>'working_year_end' ]) !!}
                    </span>
        </div>
    </div>
    <div class="form-group col-sm-6">
        <label class="control-label">Working Year End</label>
        <div class="">
                   <span class="field">
                        {!! Form::text('working_year_end', old('date_joined', $working_year_end), ['class'=>'form-control datepicker', 'autocomplete'=>'off', 'placeholder'=>'Working Year End', 'id'=>'working_year_end','data-max-date'=> $working_year_end]) !!}
                    </span>
        </div>
    </div>
        <div class="row">
            <div class="col-sm-12 text-right">
                <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Save</button>
            </div>
        </div>
    </form>
@endsection
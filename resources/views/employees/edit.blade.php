@extends('portal-index')
@section('title', 'Edit Employee')
@section('modalTitle', 'Edit Employee')

@section('modalFooter')
    <a href="{{route('employees.index')}}" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Update</button>
@endsection

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('employees.form', [
                'employee' => $data
            ])
        </div>
    </div>
@endsection

@section('post-body')
<link href="{{URL::to('/')}}/css/post-bootstrap-admin-reset.css" rel="stylesheet" xmlns="http://www.w3.org/1999/html">
<link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/plugins/droparea/droparea.css" media="screen" >
<script type="text/javascript" src="{{URL::to('/')}}/plugins/droparea/droparea.min.js"></script>
<link href="{{URL::to('/')}}/css/employees.min.css" rel="stylesheet">

<style>

    .SumoSelect>.optWrapper { z-index: 1000; }

    .pic-holder {
        position: absolute;
        text-align: left;
        padding: 0 0 0 -20px;
        margin: 10px 0 20px -10px;
    }

    .pic-holder img {
        padding: 0;
        width: 160px;
        height: 150px;
        border-radius: 50%;
        border: 10px solid #f1f2f7;
        vertical-align: middle;
        transition: opacity .5s ease;
    }

    .pic-holder button {
        position: absolute;
        display: none;
        opacity: 0;
        transition: opacity .5s;
    }

    .pic-holder button.delete-pic {
        top: 0;
        right: 0;
        transition: top 0.4s,
        right 0.4s;
    }

    .pic-holder:hover img {
        opacity: 0.5;
    }

    .pic-holder:hover button {
        display: block;
        opacity: 1;
    }

    .v-spacer{
        display: block
    }
    .v-spacer.h20 {
        height: 20px;
    }

    .v-spacer.h30 {
        height: 30px;
    }
    .v-spacer.h40 {
        height: 40px;
    }
    .v-spacer.h50 {
        height: 55px;
    }
    @keyframes popIn {
        from {
            opacity: 0;
            transform: scale(0.4);
        }
        25% {
            opacity: 0;
            transform: scale(2.25);
        }
        60% {
            opacity: 0;
            transform: scale(0.5);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>
<script src="{{URL::to('/')}}/js/employees.js"></script>
@endsection

@section('content')
    <form method="POST" action="{{ route('employees.update', $data->id) }}" id="edit_employee_form" name="edit_employee_form" data-parsley-validate="" accept-charset="UTF-8" ,
                data-quals = '[{"Title":"1", "Description":"abcde", "Institution":"Testing", "StudentNumber":"A001","DateObtained":"2015-01-01" }]'>
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PATCH">
        @yield('modalContent')
        <p>
            <div class="row">
                <div class="col-sm-12 text-right"> 
                @yield('modalFooter')
                </div>
            </div>
        </p>
    </form>
@endsection
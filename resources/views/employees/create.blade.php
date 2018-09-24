@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add New Employee')
@section('modalTitle', 'Add New Employee')

@php
    dump($errors);
@endphp

@section('modalHeader')
    <form method="POST" action="{{ route('employees.store') }}" accept-charset="UTF-8" id="create_employee_form" name="create_employee_form" class="form-horizontal">
        {{ csrf_field() }}
@endsection

@section('modalFooter')
    <input class="btn btn-primary pull-right" type="submit" value="Add">
    <a href="{{ route('employees.index') }}" class="btn btn-default pull-right" title="Show all Employees">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
</form>
@endsection

@section('modalContent')
    <form method="POST" action="{{ route('employees.store') }}" accept-charset="UTF-8" id="create_employee_form" name="create_employee_form" data-parsley-validate="">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-12">
                @include('employees.form', [
                    'employee' => null,
                    '_mode' => 'create'
                ])
            </div>
        </div>
        @if(!Request::ajax())
        <div class="box-footer">
            @yield('modalFooter') 
        </div>
        @endif
    </form>
@endsection

@section('content')
    @yield('modalContent') 
@endsection

@section('post-body')
<link href="{{URL::to('/')}}/css/post-bootstrap-admin-reset.css" rel="stylesheet" xmlns="http://www.w3.org/1999/html">
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
<link rel="stylesheet" href="{{URL::to('/')}}/css/leaves.min.css"">
@extends('portal-index')
@if(!empty($selected['employee']->id) && $selected['employee']->id !== \Auth::user()->employee_id)
    @section('title',"My Absences and leaves : ".$selected['employee']->first_name." ".$selected['employee']->surname)
    @section('subtitle', "Manage associated employee's absences and leaves")
@else
    @section('title','My Absences and leaves')
    @section('subtitle', 'Keep track and manage your absences and leaves')
@endif
@section('subtitle', 'Keep track and manage your absences and leaves')


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
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-@if(count($employees)>0)8 space-margin @else 12 @endif">
                <div class="row">
                    @include('selfservice-portal.leaves.absences.status')
                </div>
                <br>
                <div class="row panel">
                    <br>
                    @include('selfservice-portal.leaves.absences.absence')
                </div>

                <br>
            </div>
            @if(count($employees)>0)
                <div class="col-sm-4">
                    @include('selfservice-portal.leaves.absences.notification')
                </div>
            @endif
        </div>
    </div>


@endsection
@section('scripts')
    <script src="{{url('/')}}/plugins/chartjs/dist/Chart.js"></script>
    <script src="{{URL::to('/')}}/js/leaves.min.js"></script>
@endsection

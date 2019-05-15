<link rel="stylesheet" href="{{asset('css/leave.css')}}">
@extends('portal-index')
@section('title','Absences and leaves')
@section('subtitle', 'Keep track and manage your absences and leaves')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-@if(count($employees)>0)8 @else 12 @endif">
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
    <script src="{{asset('js/leaves.js')}}"></script>
@endsection

<link rel="stylesheet" href="{{URL::to('/')}}/css/leaves.min.css">
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
                <p class="inner"><strong>Error!</strong> {{ $error }}</p>
            @endforeach
        </div>
    @endif
</div>

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('selfservice-portal.leaves.absences.status')
        </div>
        <br>
        <div class="row panel section-leaves col-sm-12">
            <ul class="nav nav-tabs nav-tabs-leaves" style="background: #FFFFFF">
                <li @if($_SERVER['REQUEST_URI'] == '/leaves' || (isset($filter) && $filter['leave_status'] == App\Enums\LeaveStatusType::status_approved))class="active"@endif><a href="/leaves"><i class="glyphicon glyphicon-calendar"></i> Calendar</a></li>
                @if(count($employees) > 0)
                <li @if($_SERVER['REQUEST_URI'] == '/leaves-pending-request' || (isset($filter) && $filter['leave_status'] == App\Enums\LeaveStatusType::status_pending))class="active"@endif><a href="/leaves-pending-request"><i class="glyphicon glyphicon-exclamation-sign"></i>  Pending requests</a></li>
                @endif
                <li @if($_SERVER['REQUEST_URI'] == '/leaves-history' || $_SERVER['REQUEST_URI'] == '/leaves/filter')class="active"@endif><a href="/leaves-history"><i class="glyphicon glyphicon-list"></i>  History</a></li>
            </ul>
            <div class="">
                @if(isset($calendar))
                    <br>
                    @include('selfservice-portal.leaves.absences.filter-calendar')
                    @include('calendar_events.calendar')
                @else

                    @include('selfservice-portal.leaves.absences.absence')
                @endif
            </div>
        </div>
    </div>
    @component('partials.index')
    @endcomponent
@endsection

@section('scripts')
    <script src="{{URL::to('/')}}/js/leaves.min.js"></script>
    @if(isset($calendar))
        <script src="{{url('/')}}/plugins/moment-2.9.0/moment.min.js"></script>
        <script src="{{url('/')}}/plugins/fullcalendar-2.2.7/fullcalendar.min.js"></script>
        {!! $calendar->script() !!}
    @endif
@endsection

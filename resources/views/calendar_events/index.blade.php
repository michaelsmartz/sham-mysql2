@extends('blank')
@section('modalTitle',$calendar->title)

@section('modalContent')
    <div class="container-fluid">
        <div class="row">
            @include('calendar_events.calendar')
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
    {!! $calendar->script() !!}
@endsection

@section('modalFooter')
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Close</a>
@endsection


@section('content')
    <div class="box box-primary  panel">
        <div class="box-body">
            @yield('modalContent')
        </div>
        <div class="box-footer">
            @yield('modalFooter')
        </div>
    </div>
@endsection
}
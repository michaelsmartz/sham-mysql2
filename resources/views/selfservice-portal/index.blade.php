@extends('portal-index')
@section('css')
<link href="{{URL::to('/')}}/css/self-service-portal.css" rel="stylesheet">
<link href="{{URL::to('/')}}/css/ssp-working-hours.css" rel="stylesheet">

<style>
    #icons-container a {
        vertical-align: text-top;
    }

    #icons-container .tooltip-inner {
        min-width: 100px;
        max-width: 100%;
        font-size: 125%;
    }

    svg .icon {
        width: 30px;
    }

    .virtual-help-buttons a {
        width: 75px;
        height: 75px;
        border-radius: 50%;
        text-align: center;
        vertical-align: middle;
        margin: 0 auto;
        padding: 4px;
        position: relative;

    }

    .virtual-help-buttons svg:hover {
        /*box-shadow: 0 3px 3px rgba(0, 0, 0, 0.125) inset;*/
        /*-webkit-animation: bounce 1.1s ease-out 75ms;
        -moz-animation: bounce 1.1s ease-out 75ms;
        animation: bounce 1.1s ease-out 75ms;*/
        position: relative;
        z-index: 20;
    }

    @media (min-width: 768px) {
        .col2 {
            float: right;
        }
    }

    ::-webkit-input-placeholder { color: white; opacity: 1 !important; }
    :-moz-placeholder { color: white; opacity: 1 !important;}
    ::-moz-placeholder {color: white; opacity: 1 !important;}
    :-ms-input-placeholder {color: white;}

    .panel-heading-btn {
        float: right;
    }
    .panel-heading-btn > a {
        margin-left: 8px;
    }

    .btn-icon,
    .btn.btn-icon {
        display: inline-block;
        width: 20px;
        height: 20px;
        padding: 0;
        border: none;
        line-height: 20px;
        text-align: center;
        font-size: 14px;
    }
    .btn-icon.btn-xs {
        width: 16px;
        height: 16px;
        font-size: inherit;
        line-height: 16px;
    }

    .panel-loading .main-body {
        position: relative;
        z-index: 0;
    }
    .panel-loading.panel-expand .main-body {
        position: absolute;
    }
    .panel-loading .main-body .panel-loader {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        background: #fff;
        opacity: 0.3;
        filter: alpha(opacity=30);
        animation: fadeIn .2s;
        -webkit-animation: fadeIn .2s;
        z-index: 1020;
        -webkit-border-radius: 0 0 4px 4px;
        -moz-border-radius: 0 0 4px 4px;
        border-radius: 0 0 4px 4px;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @-webkit-keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .panel-loader > .loading-circular-x2:before {
        background: none !important;
        width: 64px !important;
        height: 64px !important;
        border-left-color: red !important;
        border-right-color: black !important;
    }

    .panel-loader + section {
        pointer-events: none;
        cursor: text;
    }

    #ajax-swallow {
        display: none !important;
        height: 0;
        max-height: 0;
    }

    #calendar {
        padding:15px;
        background-color: inherit;
    }

    #todo-main-container .slimScrollBar {
        background: rgba(255, 250, 250, 0.8) !important;
        border-radius: 2px;
    }

    #calendar {
        font-family: inherit;
    }

    #calendar .fc-button {
        box-shadow: none;
        -webkit-border-radius: 0;
        -moz-border-radius: 0;
        border-radius: 0;
    }

    .fc-state-default, .fc-state-default .fc-button-inner {
        background: #F3F3F3 !important;
        border-color: #DDDDDD;
        border-style: none solid;
        color: #646464;
        text-shadow: none;
    }

    .fc-state-disabled {
        background: #32323A !important;
        color: #fff !important;
        text-shadow: none;
        opacity: 1;
    }

    .fc-state-active, .fc-state-active .fc-button-inner, .fc-state-active, .fc-button-today .fc-button-inner, .fc-state-hover, .fc-state-hover .fc-button-inner {
        background: #32323A !important;
        color: #fff !important;
    }

    .fc-view th {
        height: 50px;
        line-height: 50px;
        text-align: center;
        background: #e4e4e4 !important;
    }

    .fc-event {
        border-radius: 4px
        padding: 4px 6px;
        text-decoration: none !important;
        outline: none !important;
    }

    .fc-event:active, .fc-event:hover, .fc-event:visited {
        text-decoration: none;
    }

    .fc-day-grid-event .fc-content {
        white-space: normal;
    }

</style>

@stop

@section('title', trans('home.SelfServicePortal.label'))
@section('subtitle',trans('home.SelfServicePortal.desc'))

@section('right-title')
<div id="icons-container" class="pull-right" style="position: absolute;top:-10px;width:100%;text-align:right;vertical-align:text-top;">
    @if (isset($allowedmodules[App\SystemModule::CONST_EMPLOYEE_PORTAL][App\SystemSubModule::CONST_MY_DETAILS]))
    <a class="btn" data-toggle="tooltip" data-container="svg" data-placement="top" title="My Profile" href="{{URL::to('/')}}/my-details">
        <svg class="icon" width="49" height="49" >
            <use xlink:href="#medical-3" />

        </svg>
        <span class="indicator-dot" id="myDetails"></span>
    </a>
    @endif

    @if (isset($allowedmodules[App\SystemModule::CONST_EMPLOYEE_PORTAL][App\SystemSubModule::CONST_MY_DISCIPLINARY_RECORDS]))
    <a class="btn" data-toggle="tooltip" data-container="svg" data-placement="top" title="My Timesheet" href="{{URL::to('/')}}/my-timesheet" >
        <svg class="icon" width="48" height="42">
            <use xlink:href="#clock-3" />
        </svg>
    </a>
    @endif
    @if (isset($allowedmodules[App\SystemModule::CONST_EMPLOYEE_PORTAL][App\SystemSubModule::CONST_MY_TRAVEL_REQUESTS]))
    <a class="btn" data-toggle="tooltip" data-container="svg" data-placement="top" title="My Travels" href="{{URL::to('/')}}/my-travels">
        <svg class="icon" width="50" height="45">
            <use xlink:href="#travel" />
        </svg>
        <span class="indicator-dot error hide" id="myTravels"><i class="fa fa-thumbs-down"></i></span>
    </a>
    @endif

    @if (isset($allowedmodules[App\SystemModule::CONST_EMPLOYEE_PORTAL][App\SystemSubModule::CONST_MY_SUGGESTIONS]))
    <a class="btn" data-toggle="tooltip" data-container="svg" data-placement="top" title="My Suggestions" href="{{URL::to('/')}}/my-suggestions">
        <svg class="icon" width="49" height="45">
            <use xlink:href="#interface-2" />
        </svg>
        <span class="indicator-dot hide" id="mySuggestions"><i class="fa fa-thumbs-up"></i> </span>
    </a>
    @endif

    @if (isset($allowedmodules[App\SystemModule::CONST_EMPLOYEE_PORTAL][App\SystemSubModule::CONST_MY_COURSES]))
    <a class="btn" data-toggle="tooltip" data-container="svg" data-placement="top" title="My E-learning" href="{{URL::to('/')}}/my-courses">
        <svg class="icon" width="48" height="48">
            <use xlink:href="#mortarboard" />
        </svg>
    </a>
    @endif

    @if (isset($allowedmodules[App\SystemModule::CONST_EMPLOYEE_PORTAL][App\SystemSubModule::CONST_MY_SURVEYS]))
    <a class="btn" data-toggle="tooltip" data-container="svg" data-placement="top" title="My Surveys" href="{{URL::to('/')}}/my-surveys">
        <svg class="icon" width="47" height="40">
            <use xlink:href="#interface-4" />
        </svg>
    </a>
    @endif
    {{--
    @if (isset($allowedmodules[App\SystemModule::CONST_EMPLOYEE_PORTAL][App\SystemSubModule::CONST_MY_DISCIPLINARY_RECORDS]))
    <a class="btn ripple-effect tooltips" title="My timeline" href="{{URL::to('/')}}/my-timeline">
        <svg  class="icon" width="52" height="52">
            <use xlink:href="#timeline-2" />
        </svg>
    </a>
    @endif
    --}}
    @if (isset($allowedmodules[App\SystemModule::CONST_EMPLOYEE_PORTAL][App\SystemSubModule::CONST_VACANCIES]))
    <a class="btn" data-toggle="tooltip" data-container="svg" data-placement="top" title="Vacancies" href="{{URL::to('/')}}/ssp-vacancies">
        <svg class="icon" width="42" height="40">
            <use xlink:href="#business-1" />
        </svg>
    </a>
    @endif
</div>
@endsection

@section('content')
@if (!empty($warnings))
<div class="col-xs-12 alert alert-danger">
    <i class="glyphicon glyphicon-exclamation-sign"></i>
    @foreach($warnings as $index => $warning)
    <div>{{$warning}}</div>
    @if($index<count($warnings)-1))<br>@endif
    @endforeach
</div>
@endif


<div hidden=""> <!-- svg menu item definitions -->
    @include('selfservice-portal.partials.menu-svg')
</div> <!-- end of svg menu item definitions -->

<div class="col-xs-12">
    <div id="message"></div>
</div>

<div id="ajax-swallow"></div>

<section id="employeedir">
    <br>
    <div class='row'>

        {{-- working hours --}}
        <div class="col2 col-lg-4 col-md-4">
            <main class="main-container" id="timesheet-main-container">
                <header class="working-hours-header">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h3>My Working Hours</h3>
                </header>
                <div class="main-body">
                    <section>
                        <div class="row">
                            <div class="timesheet">
                                <div class="working-hours">
                                    @if(isset($workingHours) && sizeof($workingHours) > 0)
                                    @if(!empty($workingHours['team']))
                                    <h2 class="list title">{{ $workingHours['team'] }}</h2>
                                    @endif
                                    @if(!empty($workingHours['description']))
                                    <h3 class="list sub-title">{{ $workingHours['description'] }}</h3>
                                    @endif

                                    <ul class="list-unstyled current-working-hours" id="accordion">
                                        @if(!empty($workingHours['time_period']))
                                        @foreach($workingHours['time_period'] as $workingDesc => $workingHour)
                                        <li data-toggle="collapse"
                                            data-target="#break_{{$workingHour['day_count']}}"
                                            data-parent="#accordion"
                                        >
                                            @if($workingDesc != '' && !is_null($workingDesc)){{ $workingDesc }}@else No description @endif
                                            <span class="pull-right">
                                                    {{ $workingHour['start_time'] }} - {{ $workingHour['end_time'] }}
                                            </span>
                                            @if(!empty($workingHour['breaks']))
                                            <span>
                                                <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" title="Click to view break details"></i>
                                            </span>
                                            @endif
                                        </li>
                                        @if(!empty($workingHour['breaks']))
                                        <ul id="break_{{$workingHour['day_count']}}" class="collapse">
                                            @foreach($workingHour['breaks'] as $periodDesc => $break)
                                            <li>
                                                @if($periodDesc != '' && !is_null($periodDesc)){{ $periodDesc }}@else No description @endif
                                                <span class="pull-right">
                                                   {{ $break['start_time'] }} - {{ $break['end_time'] }}
                                                </span>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @endif
                                        @endforeach
                                        @endif
                                    </ul>
                                    @else
                                    <p style="color: #ffffee ">You have not been assigned to a team.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>
        {{--  end of working hours --}}
    </div>
</section>
@stop


@if(!Request::ajax())
@section('post-body')
@endif
<script>
    $(document).ready(function () {

        //***Start working hours getting current day****

        let d = new Date();
        let weekday = new Array(7);
        weekday[0] = "Monday";
        weekday[1] = "Tuesday";
        weekday[2] = "Wednesday";
        weekday[3] = "Thursday";
        weekday[4] = "Friday";
        weekday[5] = "Saturday";
        weekday[6] =  "Sunday";

        let now = weekday[d.getDay()-1];

        $('.current-working-hours').children('li').filter(function(val){

            let text = $(this).text().trim();

            if (text.indexOf(now) === 0 ) {
                $('.current-working-hours > li').eq(val).addClass('today');
            }

        });
    });

    //show/hide list in working hours
    let group = $('#accordion');
    group.on('show.bs.collapse','.collapse', function() {
        group.find('.collapse.in').collapse('hide');
    });

    //***End working hours getting current day****
</script>
@if(!Request::ajax())
@endsection
@endif


@extends('index')
@php

    $title = trans('home.dashboard');
    View::share('title', $title);

@endphp

@section('title', "Dashboard" )

@section('content')
    <style>
        /*.morris-hover{position:absolute;z-index:1005;}
        .morris-hover.morris-default-style{border-radius:10px;padding:6px;color:#666;background:rgba(255, 255, 255, 0.8);border:solid 2px rgba(230, 230, 230, 0.8);font-family:sans-serif;font-size:12px;text-align:center;}
        .morris-hover.morris-default-style .morris-hover-row-label{font-weight:bold;margin:0.25em 0;}
        .morris-hover.morris-default-style .morris-hover-point{white-space:nowrap;margin:0.1em 0;}*/
        #shamUser-donut {
            height: 400px;
            padding-bottom: 25px;
        }

        svg {
            height: 370px;
        }

        #leave-bar {
            height: 400px;
            padding-bottom: 25px;
        }
    </style>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{!! $empCount !!}</div>
                            <div>Employees</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{!! $shamCount !!}</div>
                            <div>SmartzHAM registered users</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Employee Status
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="leave-bar"></div>
                </div>

                <!-- /.panel-body -->
            </div>
        </div>

        <!-- /.col-lg-8 -->
        <div class="col-lg-6 col-md-6 col-sm-6">
            {{--
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bell fa-fw"></i> Notifications Panel
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item">
                            <i class="fa fa-comment fa-fw"></i> Welcome new employee John Doe
                            <span class="pull-right text-muted small"><em>4 minutes ago</em></span>
                                </span>
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-comment fa-fw"></i> Employee party at the club house 15 March 2016
                            <span class="pull-right text-muted small"><em>2 days ago</em></span>
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-comment fa-fw"></i> Tax forms issued to all employees
                            <span class="pull-right text-muted small"><em>12 days ago</em></span>
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-comment fa-fw"></i> Mr Paul Smith resigned from the company
                            <span class="pull-right text-muted small"><em>15 minutes ago</em></span>
                        </a>
                    </div>
                    <!-- /.list-group -->
                    <a href="#" class="btn btn-default btn-block">View All Communications</a>
                </div>
                <!-- /.panel-body -->
            </div>
            --}}
            <div class="panel panel-red">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> SmartzHAM user registrations
                </div>
                <div class="panel-body">
                    <div id="shamUser-donut"></div>
                </div>
            </div>
        </div>
        <!-- /.col-lg-4 -->
    </div>
    {{--
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Quality Assurance
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="qa-bar" style="margin-left: 0px;padding-left: 0px; width: 400px; height: 400px;"></div>
                </div>

                <!-- /.panel-body -->
            </div>
        </div>
    </div>
    --}}

    <!-- /.row -->

    <!-- Morris Chart -->
    <script src="{{URL::to('/')}}/sbadmin2/bower_components/raphael/raphael-min.js"></script>
    <script src="{{URL::to('/')}}/sbadmin2/bower_components/morrisjs/morris.min.js"></script>

    <!-- Flot Chart -->
    <script src="{{URL::to('/')}}/sbadmin2/bower_components/flot/jquery.flot.js"></script>
    <script src="{{URL::to('/')}}/sbadmin2/bower_components/flot/jquery.flot.resize.js"></script>
    <script src="{{URL::to('/')}}/sbadmin2/bower_components/flot/jquery.flot.barnumbers.js"></script>

    <script>

        $(document).ready(function () {
            Morris.Donut({
                element: 'shamUser-donut',
                data: [{
                    label: "Completed",
                    value: {{$shamAssociatedEmpCount}}
                }, {
                    label: "Incomplete",
                    value: {{$shamUnassociatedEmpCount}}
                }],
                colors: ['rgb(179,41,38)', '#d9534f'],
                resize: true
            });

            // Set up our data array
            var my_data = [
                    @foreach($empStatuses as $key=>$status)
                [{{$empStatusesCounts[$key]}}, {{$key}}] @if($key<count($empStatuses)) , @endif
                @endforeach
            ];

            // Setup labels for use on the Y-axis
            var tickLabels = [
                    @foreach($empStatuses as $key=>$status)
                [{{$key}}, '{{$status}}'] @if($key<count($empStatuses)) , @endif
                @endforeach
            ];

            var options = {
                color: "#d4a71a",
                bars: {
                    show: true, horizontal: true, align: 'center', fill: 1,
                    numbers: {show: true}
                },
                xaxis: {tickLength: 0, tickDecimals: 0},
                yaxis: {ticks: tickLabels, tickLength: 0},
                grid: {hoverable: true, labelMargin: 8, borderWidth: 2, borderColor: '#f0f0f0'},
                tooltip: true
            };
            var plot = $.plot($('#leave-bar'), [my_data], options);

            {{--
            Morris.Bar({
                element: 'qa-bar',
                data: [{
                    y: 'No of Assessments',
                    a: {{$totalAssessmentCount}}
                }, {
                    y: 'Completed',
                    a: {{$totalCompletedAssessmentCount}}
                }],
                barColors: ['#d4a71a','grey'],
                xkey: 'y',
                ykeys: ['a'],
                labels: ['No of Assessments', 'Completed'],
                hideHover: 'auto',
                resize: true
            });
            --}}
        });

    </script>

@stop
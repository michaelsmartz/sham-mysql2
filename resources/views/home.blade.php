@extends('portal-index')

@php
    //$title = trans('home.dashboard');
    //View::share('title', $title);
@endphp

@section('title', "Dashboard" )
@section('subtitle', '')

@section('bodyparam', 'onpageshow=triggerFetch()')

@section('content')
    <link href="{{URL::to('/')}}/js/gridstack/gridstack.min.css" rel="stylesheet">

    <style>
        .grid-stack-item, .grid-stack-item-content {
            border-radius: 0.25rem 0.25rem 0 0; }
        .grid-stack-item-content { padding: 0 10px; }
        .palette { min-height: 90vh; background: #999 }

        .palette .grid-stack-item { margin:1em 0; }
        .palette .grid-stack-item-content {
            background: #ddf; height: 50px; width: 100% }

        .canvas { background: transparent; }
        .grid-stack-item-content { padding: 0; margin: 0; border: 2px solid #f2f2f2 }
        .portlet-header {
            line-height: 26px; font-weight: bold;
            color: #000000; -moz-user-select: none;
            white-space: nowrap; display: inline-block;
            width: 100%; position: relative;
            left:0; top: 0;
            border-color: transparent; background: transparent
        }

        .portlet-header .header .title {
            padding-left: 10px; float:left;
        }

        .portlet-header .header .transparentbar {
            background-color: transparent !important;
            display: inline;  box-shadow: none;
            border-color: transparent; opacity: 0.5
        }

        .transparentbar .transparentbtn:first-child { padding-right: 2px; }
        .transparentbar .transparentbtn:last-child {
            padding-left: 1px; padding-right: 5px;
        }

        .transparentbtn {
            padding-top: 2px !important; padding-bottom: 0 !important; border-color: transparent !important;
            vertical-align: top !important; background: transparent
        }

        .transparentbar:hover, .transparentbar .transparentbtn:active, .transparentbar .transparentbtn:focus {
            opacity: 1 !important; color: black !important;
            background: white !important; font-weight: bold !important;
        }

        .grid-stack-item-content .content {
            height: 90%;
            overflow:hidden;
            text-align: center;
            width: 100%;       /* container fits window (accommodates padding) */
            margin-left: 0; /* override left menu default left margin */
        }

        .svg-container {
            display: inline-block; position: relative;
            width: 100%; padding-bottom: 100%; /* aspect ratio */
            vertical-align: top; overflow: hidden
        }

        .grid-stack-item, .grid-stack-item-content {
            overflow: hidden !important;
        }

        .grid-stack > .grid-stack-item > .grid-stack-item-content {
            /* override from gridstack css */
            left: 0;  right: 0
        }

        .dropdown-menu { background:transparent; }
        .dropdown-menu > li { background-color: white; }
        .btn-default { background:transparent; }

        rect.d3plus_data { stroke-width: 0 !important; }
        rect.base { stroke: #eee; fill: #eee }

        .d3-tip {
            line-height: 1; padding: 6px;
            background: rgba(0, 0, 0, 0.8); color: #fff;
            border-radius: 4px; font-size: 12px
        }

        /* Creates a small triangle extender for the tooltip */
        .d3-tip:after {
            box-sizing: border-box;
            display: inline;
            font-size: 10px;
            width: 100%; line-height: 1;
            color: rgba(0, 0, 0, 0.8); content: "\25BC";
            position: absolute; text-align: center
        }

        #d3plus_message {
            font-size: 40px !important; padding-top: 12px !important; line-height: 38px !important
        }

        .d3plus_title tspan { font-weight: bold; }

        #d3plus_graph_xgrid line, #d3plus_graph_ygrid line {
            stroke-dasharray: 1,2;
        }

        #focus-overlay {
            background: rgba(0, 0, 0, 0.95) none repeat scroll 0 0;
            bottom: 0; left: 0; position: fixed; right: 0; top: 0; z-index: 9
        }

        .widget-focus-enabled {
            position: relative; z-index: 9999 !important
        }

        .widget-focus-enabled .grid-stack-item-content {
            background: white none repeat scroll 0 0 !important;
        }

        .d3plus_tooltip { z-index: 999999 !important; }

        .d3plus_button_element {
            right: -1px !important; width: 30px }

        #d3plus_label_Headcount_rect, #d3plus_label_Headcount_rect tspan {
            stroke: #FA7240 !important; fill: #FA7240 !important; font-size: 55px
        }

        body.focus-mode .navbar, body.focus-mode .sidebar-nav {
            opacity: 0;
        }

        .link-disabled {
            cursor: not-allowed; opacity: 0.5; pointer-events: none }

        /** font fix for helvetica on chrome **/
        body {
            -webkit-animation-duration: 0.1s;
            -webkit-animation-name: fontfix;
            -webkit-animation-iteration-count: 1;
            -webkit-animation-timing-function: linear;
            -webkit-animation-delay: 0.1s;
        }

        @-webkit-keyframes fontfix {
            from { opacity: 1; }
            to { opacity: 1; }
        }

    </style>

    <div class="device-xs visible-xs"></div>
    <div class="device-sm visible-sm"></div>
    <div class="device-md visible-md"></div>
    <div class="device-lg visible-lg"></div>
    <div class="device-xl visible-xl"></div>

    <section>
        <p></p>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h4><i class="fa fa-users fa-fw"></i> Central HR</h4>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="canvas">
                    <div class="grid-stack" id="gridEmployee">
                        <div class="grid-stack-item" data-gs-x="0" data-gs-y="0" data-gs-width="4" data-gs-height="3">
                            <div class="grid-stack-item-content">
                                <div class="portlet-header" style="text-align:center; vertical-align:middle;">
                                <span class="header">
                                    <div class="title">Headcount</div>
                                    @include('dashboard-report.partials.dropdown-menu')
                                </span>
                                </div>
                                <div class="content" id="employeeHeadcount"></div>
                            </div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="5" data-gs-y="0" data-gs-width="8" data-gs-height="6">
                            <div class="grid-stack-item-content">
                                <div class="portlet-header" style="text-align:center; vertical-align:middle;">
                                <span class="header">
                                    <div class="title">Headcount by Department</div>
                                    @include('dashboard-report.partials.dropdown-menu')
                                </span>
                                </div>
                                <div class="content" id="employeeHeadcountDepartment"></div>
                            </div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="0" data-gs-y="3" data-gs-width="4" data-gs-height="3">
                            <div class="grid-stack-item-content">
                                <div class="portlet-header" style="text-align:center; vertical-align:middle;">
                                <span class="header">
                                    <div class="title">Department count</div>
                                    @include('dashboard-report.partials.dropdown-menu')
                                </span>
                                </div>
                                <div class="content" id="departmentCount"></div>
                            </div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="0" data-gs-y="6" data-gs-width="5" data-gs-height="6">
                            <div class="grid-stack-item-content">
                                <div class="portlet-header" style="text-align:center; vertical-align:middle;">
                                <span class="header">
                                    <div class="title">Headcount Profiles</div>
                                    @include('dashboard-report.partials.dropdown-menu')
                                </span>
                                </div>
                                <div class="content" id="employeeHeadcountProfiles"></div>
                            </div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="5" data-gs-y="6" data-gs-width="7" data-gs-height="6">
                            <div class="grid-stack-item-content">
                                <div class="portlet-header" style="text-align:center; vertical-align:middle;">
                                <span class="header">
                                    <div class="title">Staff Turnover</div>
                                    @include('dashboard-report.partials.dropdown-menu')
                                </span>
                                </div>
                                <div class="content" id="employeeStaffTurnover"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <p></p><br>
                <h4><i class="fa fa-users fa-fw"></i>Available Assets</h4>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="canvas">
                    <div class="grid-stack" id="gridAssets">
                        <div class="grid-stack-item" data-gs-x="0" data-gs-y="0" data-gs-width="12" data-gs-height="6">
                            <div class="grid-stack-item-content">
                                <div class="portlet-header" style="text-align:center; vertical-align:middle;">
                                <span class="header">
                                    <div class="title">Assets</div>
                                    @include('dashboard-report.partials.dropdown-menu')
                                </span>
                                </div>
                                <div class="content" id="availableAssets"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <p></p><br>
                <h4><i class="fa fa-certificate fa-fw"></i> Quality Assurance</h4>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="canvas">
                    <div class="grid-stack" id="gridQA">
                        <div class="grid-stack-item" data-gs-x="0" data-gs-y="0" data-gs-width="4" data-gs-height="3">
                            <div class="grid-stack-item-content">
                                <div class="portlet-header" style="text-align:center; vertical-align:middle;">
                                <span class="header">
                                    <div class="title">Total Evaluation</div>
                                    @include('dashboard-report.partials.dropdown-menu')
                                </span>
                                </div>
                                <div class="content" id="totalevaluation"></div>
                            </div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="5" data-gs-y="0" data-gs-width="8" data-gs-height="6" data-gs-no-resize="true" data-gs-no-move="true">
                            <div class="grid-stack-item-content">
                                <div class="portlet-header" style="text-align:center; vertical-align:middle;">
                                <span class="header">
                                    <div class="title">QA Assessment Status</div>
                                    @include('dashboard-report.partials.dropdown-menu')
                                </span>
                                </div>
                                <div class="content" id="qaAssessmentStatus"></div>
                            </div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="0" data-gs-y="3" data-gs-width="4" data-gs-height="3">
                            <div class="grid-stack-item-content">
                                <div class="portlet-header" style="text-align:center; vertical-align:middle;">
                                <span class="header">
                                    <div class="title">Average Score</div>
                                    @include('dashboard-report.partials.dropdown-menu')
                                </span>
                                </div>
                                <div class="content" id="averagescore"></div>
                            </div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="0" data-gs-y="6" data-gs-width="12" data-gs-height="7" data-gs-no-resize="true" data-gs-no-move="true">
                            <div class="grid-stack-item-content">
                                <div class="portlet-header" style="text-align:center; vertical-align:middle;">
                                <span class="header">
                                    <div class="title">QA Product Stats</div>
                                    @include('dashboard-report.partials.dropdown-menu')
                                </span>
                                </div>
                                <div class="content" id="qaAssessmentProcess"></div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <p></p><br>
                <h4><i class="fa fa-mortar-board fa-fw"></i>E-Learning</h4>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="canvas">
                    <div class="grid-stack" id="gridElearning">
                        <div class="grid-stack-item" data-gs-x="0" data-gs-y="0" data-gs-width="12" data-gs-height="6">
                            <div class="grid-stack-item-content">
                                <div class="portlet-header" style="text-align:center; vertical-align:middle;">
                                <span class="header">
                                    <div class="title">Courses</div>
                                    @include('dashboard-report.partials.dropdown-menu')
                                </span>
                                </div>
                                <div class="content" id="elearningCourses"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <p></p><br>
                <h4><i class="fa fa-bar-chart fa-fw"></i>Performance</h4>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="canvas">
                    <div class="grid-stack" id="gridPerformance">
                        <div class="grid-stack-item" data-gs-x="0" data-gs-y="0" data-gs-width="4" data-gs-height="3">
                            <div class="grid-stack-item-content">
                                <div class="portlet-header" style="text-align:center; vertical-align:middle;">
                                <span class="header">
                                    <div class="title">Total Disciplinary Actions</div>
                                    @include('dashboard-report.partials.dropdown-menu')
                                </span>
                                </div>
                                <div class="content" id="totaldisciplinaryaction"></div>
                            </div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="5" data-gs-y="0" data-gs-width="4" data-gs-height="3">
                            <div class="grid-stack-item-content">
                                <div class="portlet-header" style="text-align:center; vertical-align:middle;">
                                <span class="header">
                                    <div class="title">Total Rewards</div>
                                    @include('dashboard-report.partials.dropdown-menu')
                                </span>
                                </div>
                                <div class="content" id="totalrewards"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('scripts')

    <script>
        var asyncQueues = {
            a: window.asyncJS(), b: window.asyncJS(), c: window.asyncJS()
        }, dB = null;

        //asyncQueues.a = asyncQueues.b = asyncQueues.c = window.asyncJS();
        asyncQueues.a.add("{{URL::to('/')}}/js/gridstack-pack.js");
        asyncQueues.a.whenDone(function() {
            // do something with lodash and gridstack
            var options = {
                cellHeight: 30, float: true,
                acceptWidgets: '.grid-stack-item', disableResize: true,
                resizable: { handles: 'se' }
            };
            $('.grid-stack').gridstack(options);
        });

        asyncQueues.b.add("{{URL::to('/')}}/js/moment-pack.js");
        asyncQueues.c.add("{{URL::to('/')}}/js/d3-pack.js");

        function loadScript(url, callback) {
            var script = document.createElement("script");
            script.type = "text/javascript";
            script.async = true;
            if (script.readyState) {
                script.onreadystatechange = function () {
                    if (script.readyState == "loaded" || script.readyState == "complete") {
                        script.onreadystatechange = null;
                        if (callback && typeof callback === "function") {
                            callback();
                        }
                    }
                };
            } else {
                script.onload = function () {
                    if (callback && typeof callback === "function") {
                        callback();
                    }
                };
            }
            script.src = url;
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(script);
        }

        function triggerFetch(){
            var asyncQ, x, y, x1, y1;

            if (typeof(asyncQ) == 'undefined') {
                asyncQ = window.asyncJS();
                asyncQ.add("{{URL::to('/')}}/js/dashboard-main.js");
                asyncQ.whenDone(function() {

                    $('.savePng').click(DashboardApp.savePng);
                    DashboardApp.chartFocus();

                    /* check if browser supports Worker or not */
                    if (window.Worker) {
                        // Instantiating the Worker
                        var worker = new Worker("js/dashboard-worker.js");
                        var urlsObj = ['getHeadcountData', 'getHeadcountDeptData', 'getNewHiresData',
                                       'getAssetData', 'getTotalAssessmentData', 'getQALastFiveDaysData','getQAEvaluationScoresData', 'getCourseData', 'getRewardCount','getDisciplinaryActionCount'];

                        urlsObj.forEach(function (prop) {
                            worker.postMessage(['../' + prop ,prop]);
                        });

                        worker.onmessage = function(e){
                            //console.log(e.data);
                            var options = {
                                'getHeadcountData': [
                                    {type:'tree_map', container:'#employeeHeadcount', data:e.data.data, set:1},
                                    {type:'tree_map', container:'#employeeHeadcountProfiles', data:e.data.data1, set:2}
                                ],
                                'getHeadcountDeptData': [
                                    {type:'bar', container:'#employeeHeadcountDepartment', data:e.data.data1, set:1},
                                    {type:'tree_map', container:'#departmentCount', data:e.data.data, set:1}
                                ],
                                'getNewHiresData': [
                                    {type:'line', container:'#employeeStaffTurnover', data:e.data.data, set:1}
                                ],
                                'getAssetData': [
                                    {type:'bar', container:'#availableAssets', data:e.data.data, set:2}
                                ],
                                'getTotalAssessmentData': [
                                    {type:'tree_map', container:'#totalevaluation', data:e.data.data, set:1},
                                    {type:'tree_map', container:'#averagescore', data:e.data.data1, set:1}
                                ],
                                'getQALastFiveDaysData':[
                                    {type:'bar', container:'#qaAssessmentProcess', data:e.data.data, set:4},
                                ],
                                'getQAEvaluationScoresData':[
                                    {type:'pie', container:'#qaAssessmentStatus', data:e.data.data, set:1}
                                ],
                                'getCourseData': [
                                    {type:'bar', container:'#elearningCourses', data:e.data.data, set:3}
                                ],
                                'getRewardCount': [
                                    {type:'tree_map', container:'#totalrewards', data:e.data.data, set:1}
                                ],
                                'getDisciplinaryActionCount': [
                                    {type:'tree_map', container:'#totaldisciplinaryaction', data:e.data.data, set:1}
                                ]
                            };
                            options[e.data.url].forEach(function(el) {
                                x = {container: el.container, data: el.data, set:el.set};
                                y = DashboardApp.drawCharts(el.type, x);
                                y.draw(); //draw the graph here, the worker brought the data
                            });
                        };
                    }
                });
            }
        }
    </script>
@endsection

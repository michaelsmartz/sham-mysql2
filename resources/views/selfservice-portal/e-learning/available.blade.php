@extends('portal-index')
@section('title','My E-learning')

@section('post-body')
    <link href="{{URL::to('/')}}/css/Amaran/amaran.min.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/css/nicescroll.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/css/metro-colors.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/css/self-service-portal.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/css/css-pack.css" rel="stylesheet">

    {{--TODO remove and add from public assets--}}
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        iframe {
            width: 100%;
            /*min-height: 45px;*/
            /*height: 100% !important;*/
            overflow: hidden !important;
        }
        .loadMsg {
            width: 100%;
            height: 100%;
            font-weight: bold;
            text-align: center;
            display: table;
            font-size:14pt;
        }
        .loadMsg div {
            display: table-cell;
            vertical-align: middle;
        }
        .text-primary {
            color: #000000;
        }

        .iframe-container {
            overflow: hidden;
            padding-top: 56.25%;
            position: relative;
        }

        .iframe-container iframe {
            border: 0;
            height: 100%;
            left: 0;
            position: absolute;
            top: 0;
            width: 100%;
        }

        /* 4x3 Aspect Ratio */
        .iframe-container-4x3 {
            padding-top: 75%;
        }
    </style>

    <script src="{{URL::to('/')}}/js/Amaran/jquery.amaran.min.js"></script>
    <script src="{{URL::to('/')}}/js/jquery.nicescroll-3.6.8.min.js"></script>
    <script src="{{URL::to('/')}}/js/my-elearning.js"></script>
    <script>
        $(function() {
            // load iframe content
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                paneID = $(e.target).attr('href');
                src = $(paneID).attr('data-src');
                // if the iframe hasn't already been loaded once
                if($(paneID+" iframe").attr("src")=="")
                {
                        $(paneID+" iframe").attr("src",src);
                }
                $(paneID+" iframe").load(function() {
                    // hide loading message when iframe loaded
                    $(paneID+" .loadMsg").hide();
                });
            });
        });
        $(document).ready(function(){
            var url = window.location.href;
            var activeTab = url.substring(url.indexOf("#") + 1);
            if(activeTab == "mycourse")
            {
                $("li").removeClass("active");
                $('#mycourses').click();
                $('#mycourses').addClass("active");
            }
        });
    </script>
@stop

<?php
$courseBaseBgClasses = [
    'bg-lightBlue',
    'bg-teal',
    'bg-amber',
    'bg-mauve',
    'bg-taupe',
    'bg-steel',
    'bg-olive',
    'bg-Pink',
    'bg-darkBrown',
    'bg-darkCyan',
    'bg-darkCobalt',
    'bg-darkOrange',
    'bg-lightOlive',
    'bg-lightRed'
];
//$courseBgClasses = ['bg-lightBlue','bg-teal','bg-amber','bg-mauve','bg-taupe','bg-steel','bg-olive','bg-Pink'];
$courseBgClasses =    $courseBaseBgClasses;
if(count($coursesAvailable)>12)
{
    for ($x = 12; $x <= count($coursesAvailable); $x++)
    {
        $colourindex = $x % 12;
        $courseBgClasses[] = $courseBaseBgClasses[$colourindex];
    }
}
?>
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

    <div class="col-xs-12">
        <div id="message"></div>
    </div>

    <section id="elearning">
        <br>
        <ul class="nav nav-tabs nav-justified" id="myTabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#sectionA">Available</a>
            </li>
            @if(sizeof($warnings) == 0)
                <li class="nav-item">
                    <a class="nav-link" id="mycourses" data-toggle="tab" href="#myCoursesTab">My courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#myAssessmentsTab">My assessments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"data-toggle="tab" href="#qAndATab">Questions & Answers</a>
                </li>
            @endif
        </ul>
        <p></p>
        <div class="tab-content">
            <!-- available courses content -->
            <div id="sectionA" class="tab-pane fade in active"> <!-- available courses content start -->
                <p></p>
                <div class="panel panel-default">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            @if(count($coursesAvailable)>0)
                                <div class="metro-tile-container">
                                    <?php $counter = 0; ?>
                                    @foreach($coursesAvailable as $index => $course)
                                        <div class="metro-tile metro-tile-lg carousel slide" data-ride="carousel" id="myCarousel-{{$index}}" data-interval="false">
                                            <div class="hide tile-progressbar" title="" data-html="true" data-wenk="<h3 class='text-info'><b>65%</b></h3> completed">
                                                <span style="width: 65%;"></span>
                                            </div>

                                            <div class="carousel-inner">

                                                <div class="metro-tile-page item active fg-white {{$courseBgClasses[$counter]}}" data-slide-number="0">
                                                    <h4>
                                                        {{$course->description}}
                                                        @if(count($course->employees) > 0)
                                                            <i class="text-primary fa fa-info-circle" data-toggle="tooltip" data-original-title="{{count($course->employees)}} {{str_plural('person', count($course->employees))}} enrolled" data-wenk="{{count($course->employees)}} {{str_plural('person', count($course->employees))}} enrolled"></i>
                                                        @endif
                                                    </h4>
                                                    @if(!$course->enrolled)
                                                        <div class="backside-button" role="button">
                                                            <span class="enrol" data-id="{{$course->id}}">Enrol on this course</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="metro-tile-page item fg-white {{$courseBgClasses[$counter]}}" data-slide-number="1">
                                                    <div class="">
                                                        <div class="row">
                                                            <div class="description">
                                                                <strong>Description</strong>
                                                            </div>
                                                            <div class="objective">
                                                                <strong>Objectives</strong>
                                                            </div>
                                                        </div>
                                                        <div class="overflow-container">
                                                            <p class="description">{{$course->overview}}</p>
                                                            <p class="objective">{{$course->objectives}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Carousel nav -->
                                            <a href="#myCarousel-{{$counter}}" class="left carousel-control" title="previous content" data-slide="prev">
                                                <span class="fa fa-chevron-left fa-2x"></span>
                                            </a>
                                            <a href="#myCarousel-{{$counter}}" class="right carousel-control"title="next content" data-slide-to="1">
                                                <span class="fa fa-chevron-right fa-2x"></span>
                                            </a>
                                        </div>
                                        <?php $counter++; ?>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-success">There are no courses available yet</span>
                                <br><br>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div id="myCoursesTab" class="tab-pane" data-src="{{URL::to('/')}}/my-elearning/my-courses">
                <div class="panel panel-default">
                    <div class="loadMsg"><div><i class="fa fa-spin"></i> Loading...</div></div>
                    <div class="iframe-container">
                        <iframe id="myCoursesFrame" src="" scrolling="no" frameborder="0"></iframe>
                    </div>
                </div>
            </div>

            <div id="myAssessmentsTab" class="tab-pane" data-src="{{URL::to('/')}}/my-elearning/my-assessments">
                <div class="panel panel-default">
                    <div class="loadMsg"><div><i class="fa fa-spin"></i> Loading...</div></div>
                    <div class="iframe-container">
                        <iframe src="" scrolling="no" frameborder="0"></iframe>
                    </div>
                </div>
            </div>

            <div id="qAndATab" class="tab-pane"  data-src="{{URL::to('/')}}/my-elearning/questions">
                <div class="panel panel-default">
                    <div class="iframe-container">
                        <iframe id="qAndAFrame" src="" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
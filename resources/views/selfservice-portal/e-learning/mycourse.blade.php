{{--@section('scripts')--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap Core CSS -->
    <link href="{{URL::to('/')}}/sbadmin2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="{{URL::to('/')}}/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="{{URL::to('/')}}/css/metro-colors.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/css/self-service-portal.css" rel="stylesheet">
    <style>
        .progress, .progress-bar {
            height: 18px;
        }

    </style>
    <!-- jQuery -->
    <script src="{{URL::to('/')}}/plugins/sbadmin2/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{URL::to('/')}}/plugins/sbadmin2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Custom CSS -->
    <link href="{{URL::to('/')}}/plugins/sbadmin2/dist/css/sb-admin-2.css" rel="stylesheet">

    <script type="text/javascript">

        // set up jQuery with the CSRF token, or else post routes will fail
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        window.onload = function() {

            $("[data-toggle='tooltip']").tooltip({title: 'Completion percentage', placement: 'auto right',container: 'body'});

            $('.begin,.resume').click(function(e) {
                e.preventDefault();
                top.window.location.href = '{{URL::to('/')}}/my-course/' + $(this).data('id');
                //parent.location.href = 'my-courses/' + $(this).data('id');
                //document.location.href = 'my-courses/' + $(this).data('id');
            });

            $('.restart').click(function(e) {
                e.preventDefault();
                top.window.location.href = '{{URL::to('/')}}/my-courses/' + $(this).data('id')+'/restart';
                //parent.location.href = 'my-courses/' + $(this).data('id');
                //document.location.href = 'my-courses/' + $(this).data('id');
                //alert('Course will be restarted....');
            });
        }
    </script>
{{--@stop--}}

<body style="background-color: white; padding-left:15px;padding-right:15px;">

<?php
$courseBgClasses = ['bg-lightBlue','bg-teal','bg-amber','bg-mauve','bg-taupe','bg-steel','bg-olive','bg-Pink'];
?>

<p></p>
<div class="panel panel-default">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="table-responsive">
                <table class="table table-hover course-list">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th class="hidden-xs">Progress</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($myCourses) && sizeof($myCourses)>0)
                        @foreach($myCourses as $course)
                            <tr>
                                <td class="course-name">
                                    <a class="accordion-toggle" data-toggle="collapse"
                                       href="#TOC-{{$course['Id']}}">
                                        <span>{{$course['Description']}}</span>
                                        <i class="text-primary fa fa-info-circle" data-toggle="tooltip"
                                           data-original-title="{{$course['CourseParticipantStatus']['Description']}}"></i>
                                    </a>
                                </td>
                                <td class="course-progress">
                                    <div class="progress" data-toggle="tooltip" data-original-title="{{intval($course['ProgressPercentage'])}}%">
                                        <div class="progress-bar" style="width: {{intval($course['ProgressPercentage'])}}%; background-color: black; text-align: center; color:#5bc0de">
                                            {{intval($course['ProgressPercentage'])}}%
                                        </div>
                                    </div>
                                </td>
                                <td class="actions edit">
                                    <div class="settings-dropdown-group">
                                        @if($course['CourseParticipantStatus']['Id'] == 3)
                                            <span class="btn btn-success" style="cursor: default !important;" data-id="{{$course['Id']}}"><span class="text-white">Complete</span></span>
                                            <span class="btn btn-info restart" data-id="{{$course['Id']}}">Restart</span>
                                        @elseif($course['ProgressPercentage']>0)
                                            <a class="btn btn-info resume" data-id="{{$course['Id']}}" href="#">Resume </a>
                                        @else
                                            <a class="btn btn-info begin" data-id="{{$course['Id']}}" href="#">Begin </a>
                                        @endif
                                        {{--
                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" @if($course['ProgressPercentage']==0) disabled @endif>
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>

                                        @if($course['ProgressPercentage']>0)
                                        <ul class="dropdown-menu" role="menu">
                                            <li>
                                                <a class="restart" data-id="{{$course->Cours->Id}}" href="#">Start from beginning</a>
                                            </li>
                                        </ul>
                                        @endif
                                        --}}
                                    </div>
                                </td>
                            </tr>
                            @if(count($course['Modules']) > 0)
                                <tr class="collapse" id="TOC-{{$course['Id']}}">
                                    <td class="course-name" colspan="3">
                                        <ul class="list-unstyled">
                                            @foreach($course['Modules'] as $item)
                                                <li><strong>{{$item['Description']}}</strong></li>
                                                <ul class="list-unstyled">
                                                    @foreach($item['Topics'] as $topic)
                                                        <li>{{$topic['Header']}}</li>
                                                    @endforeach
                                                </ul>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endif

                        @endforeach
                    @else
                        <tr>
                            <td class="course-name" colspan="3">
                                <span class="text-success">There are no enrolled courses available yet</span>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
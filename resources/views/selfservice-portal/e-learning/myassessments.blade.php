<!DOCTYPE html>
<head>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{asset('css/app.min.css')}}">
    <script src="{{asset('js/app.js')}}"></script>

    <link href="{{URL::to('/')}}/css/metro-colors.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/css/self-service-portal.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{URL::to('/')}}/css/sb-admin-2.css" rel="stylesheet">
</head>

<?php
$courseCssClasses = ['lightBlue', 'teal', 'amber', 'mauve', 'taupe', 'steel', 'olive', 'Pink'];
?>

<body style="background-color: white; padding-left:15px;padding-right:15px;">
<p></p>
<div class="panel panel-default">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="menu">
                <div class="accordion" id="tree_accordion">
                    @php $courseIdx = 0; @endphp
                    @foreach($myCourses as $index=>$course)
                        @if(!$course->HasAssessmentResponses) @continue @endif
                        <div class="accordion-group">
                            <div class="accordion-heading {{$courseCssClasses[$courseIdx]}}">
                                <a class="accordion-toggle" data-toggle="collapse"
                                   href="#{{$course->id}}">{{$course->description}}
                                </a>
                                <span class="badge
                                        @if($course['courseParticipantStatus']['id'] == \App\Enums\CourseParticipantStatusType::Completed)
                                        bg-green
@endif
                                        pull-right">{{$course['courseParticipantStatus']['description']}}</span>
                            </div>
                            <div class="accordion-body collapse" id="{{$course->id}}">
                                <div class="accordion-inner">
                                    <div class="overall-statistics">
                                        <p>
                                            <strong>Overall Score</strong>:
                                            <span class="badge {{--bg-green--}} score">{{$course->OverallScore}}</span>
                                        </p>
                                    </div>
                                    <!-- each assessment is a page report -->
                                    @foreach($course->moduleAssessment as $assessment)
                                        <div class="page-report">
                                            <h3>{{$assessment->description}}</h3>
                                            <p class="page-statistics">
                                                <strong>Pass mark</strong>: {{$assessment->pass_mark}}
                                                <span class="stat-spacer">|</span>
                                                {{--<strong>Score</strong>: {{$assessment->StudentScore}} of {{$assessment->pass_mark}}--}}
                                                <span class="stat-spacer">|</span>
                                                {{--<strong>Date</strong>: {{ \Carbon\Carbon::parse($assessment->Response->DateCompleted)->toDateString() }}--}}
                                            </p>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th class="col-lg-3 col-md-3 col-sm-3">Question</th>
                                                        <th class="col-lg-4 col-md-4 col-sm-4">Answer</th>
                                                        <th class="col-lg-1 col-md-1 col-sm-1">Score</th>
                                                        <th class="col-lg-4 col-md-4 col-sm-4">Expected</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    {{--@foreach($assessment->Questions as $question)--}}
                                                        {{--<tr class="assessment-text">--}}
                                                            {{--<td><p>{{$question->ModuleQuestion->Title}}</p></td>--}}
                                                            {{--<td>--}}
                                                                {{--@foreach($question->ResponseDetails as $studentResponse)--}}
                                                                    {{--<p>{{$studentResponse->Content}}</p>--}}
                                                                {{--@endforeach--}}
                                                            {{--</td>--}}
                                                            {{--<td><span>{{$question->SumPoints}}</span></td>--}}
                                                            {{--<td>--}}
                                                                {{--@if($question->ModuleQuestion->ModuleQuestionTypeId == \App\Enums\ModuleQuestionType::OpenText)--}}
                                                                    {{--@if($assessment->Response->Reviewed)--}}
                                                                        {{--<span>Reviewed by trainer</span>--}}
                                                                    {{--@else--}}
                                                                        {{--<span>Will be reviewed by trainer</span>--}}
                                                                    {{--@endif--}}
                                                                {{--@else--}}
                                                                    {{--@foreach($question->ModuleQuestion->Choices as $choice)--}}
                                                                        {{--@if($choice->CorrectAnswer)--}}
                                                                            {{--<p>{{$choice->ChoiceText}}</p>--}}
                                                                        {{--@endif--}}
                                                                    {{--@endforeach--}}
                                                                {{--@endif--}}
                                                            {{--</td>--}}
                                                        {{--</tr>--}}
                                                    {{--@endforeach--}}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @php $courseIdx++; @endphp
                    @endforeach

                    @if($courseIdx == 0)
                        <div class="accordion-group">
                            <div class="accordion-heading olive">
                                <a class="accordion-toggle" data-toggle="collapse"
                                >There are no assessment reports for the time-being
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class=" hide accordion-group">
                        <div class="accordion-heading olive">
                            <a class="accordion-toggle" data-toggle="collapse"
                               href="#level2">Working Smarter: Using Technology to Your Advantage
                            </a>
                            <span class="badge bg-green pull-right">complete</span>
                        </div>
                        <div class="accordion-body collapse" id="level2">
                            <div class="accordion-inner">
                                <div class="overall-statistics">
                                    <p>
                                        <strong>Completed</strong>: <span class="progress_percent">100%</span>
                                    </p>
                                    <p>
                                        <strong>Overall Score</strong>:
                                        <span class="badge bg-green score">80%</span>
                                    </p>
                                </div>
                                <!-- each assessment is a page report -->
                                <div class="page-report">
                                    <h3>Contact Management Applications </h3>
                                    <p class="page-statistics">
                                        <strong>Score</strong>: 0.00%
                                        <span class="stat-spacer">|</span>
                                        <strong>Correct</strong>: 0
                                        <span class="stat-spacer">|</span>
                                        <strong>Incorrect</strong>: 1
                                        <span class="stat-spacer">|</span>
                                        <strong>Points</strong>: 0 of 1
                                        <span class="stat-spacer">|</span>
                                        <strong>Time on Page</strong>: 0:00:00
                                    </p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th class="col-md-3">Question</th>
                                                <th class="col-md-4">Answer</th>
                                                <th class="col-md-1">Correct</th>
                                                <th class="col-md-1">Score</th>
                                                <th class="col-md-2">Expected</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="danger">
                                                <td>
                                                    <p>
                                                        What tips do you have for using contact management
                                                        software?
                                                    </p>
                                                </td>
                                                <td><p>Well, I don't know</p></td>
                                                <td><span>No</span></td>
                                                <td>0</td>
                                                <td>
<span>
    <span>Answer will be reviewed by instructor.</span>
</span>
                                                </td>
                                                <td></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="page-report">
                                    <h3>Post-Course Assessment</h3>
                                    <p class="page-statistics">
                                        <strong>Score</strong>: 100.00%
                                        <span class="stat-spacer">|</span>
                                        <strong>Correct</strong>: 4
                                        <span class="stat-spacer">|</span>
                                        <strong>Incorrect</strong>: 0
                                        <span class="stat-spacer">|</span>
                                        <strong>Points</strong>: 4 of 4
                                        <span class="stat-spacer">|</span>
                                    </p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th class="col-md-3">Question</th>
                                                <th class="col-md-4">Answer</th>
                                                <th class="col-md-1">Correct</th>
                                                <th class="col-md-1">Score</th>
                                                <th class="col-md-2">Expected</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="success">
                                                <td>
                                                    <p>
                                                        What do you want to get from this course?
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>
                                                        <span>A good planning idea to use technology efficiently at work.</span>
                                                    </p>
                                                </td>
                                                <td>
                                                    <span>Recorded</span>
                                                </td>
                                                <td>1</td>
                                                <td>
<span>
    <span>Answer will be reviewed by instructor.</span>
</span>
                                                </td>
                                                <td></td>
                                            </tr>
                                            </tbody>
                                            <tbody>
                                            <tr class="success">
                                                <td>
                                                    <p>
                                                        What technology challenges do you face?
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>
    <span>
        Efficient use of technology at the workplace
    </span>
                                                    </p>
                                                </td>
                                                <td>
                                                    <span>Recorded</span>
                                                </td>
                                                <td>1</td>
                                                <td>
<span>
    <span>
        Answer will be reviewed by instructor.
    </span>
</span>
                                                </td>
                                                <td>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <tbody>
                                            <tr class="success">
                                                <td>
                                                    <p>
                                                        What e-mail application do you currently use? What applications
                                                        have you used in the past? Which do you prefer and why?
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>
    <span>
        Microsoft outlook
    </span>
                                                    </p>
                                                </td>
                                                <td>
                                                    <span>Recorded</span>
                                                </td>
                                                <td>1</td>
                                                <td>
<span>

    <span>
        Answer will be reviewed by instructor.
    </span>
</span>
                                                </td>
                                                <td></td>
                                            </tr>
                                            </tbody>
                                            <tbody>
                                            <tr class="success">
                                                <td>
                                                    <p>
                                                        What tips do you have for managing e-mail?
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>
    <span>
        No tips really, apart from making templates for repeated e-mails.
    </span>
                                                    </p>
                                                    <div>
                                                        <div id="question-history-Pre-Assignment_q4"
                                                             class="accordion-body collapse">
                                                            <div class="history-item">
                                                                <div class="alert alert-success">
                                                                    <p>
                                                                        <strong> Oct 31, 2016 at 06:01 AM</strong>
                                                                    </p>
                                                                    <p>
                    <span>
                        None actually
                    </span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span>Recorded</span>
                                                </td>
                                                <td>1</td>
                                                <td>
<span>
    <span>
        Answer will be reviewed by instructor.
    </span>
</span>
                                                </td>
                                                <td></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
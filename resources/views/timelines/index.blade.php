@extends('portal-index')
@section('title','Timeline')
@section('subtitle', 'All employees milestones in one place')
@section('right-title')
    <a href="{{route('employees.index') }}" class="btn btn-default pull-right" title="Show all Employees">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
@endsection
@section('content')
    {{ AsyncWidget::run('timeline_header', ['employee' => $id]) }}
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#timeline">Timeline</a></li>
        <li><a href="{{URL::to('rewards')}}{{'/employee/'}}{{ $id }}">Rewards</a></li>
        <li><a href="{{URL::to('disciplinaryactions')}}{{'/employee/'}}{{ $id }}">Disciplinary Actions</a></li>
    </ul>
    <br>

    <div class="row">
        <div class="col-md-12">
            <div class="">
                <!-- Timeline content-->
                <div id="timeline" class="tab-pane fade in active">
                    <p></p>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <!-- <div class="pull-right" ><label for="TimelineStart">Start Date:</label> <input name="TimelineStart" type="date" value="" id="TimelineStart"> <label for="TimelineEnd">End Date:</label> <input name="TimelineEnd" type="date" value="" id="TimelineEnd"></div>-->

                                    <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i>Timeline</h3>
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel" style="margin-bottom:5px">
                                    <div class="row form form-inline" style="margin:5px">
                                        <div class="col-md-5">
                                            <label for=""><strong>Show items:</strong> </label>
                                        </div>
                                    </div>
                                    <div class="row form form-inline" style="margin:5px">
                                        <div class="col-md-3">
                                            <label for="chkDepartment">Departments: </label>
                                            <input id="chkDepartment" name="chkDepartment" type="checkbox" data-shortcut-type="1" data-group-cls="btn-group-sm" data-off-active-cls="btn-warning" data-off-title="No" data-on-title="Yes" checked>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="chkDisciplinary">Disciplinary actions: </label>
                                            <input id="chkDisciplinary" name="chkDisciplinary" type="checkbox" data-shortcut-type="3" data-group-cls="btn-group-sm" data-off-active-cls="btn-warning" data-off-title="No" data-on-title="Yes" checked>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="chkReward">Rewards: </label>
                                            <input id="chkReward" name="chkReward" type="checkbox" data-shortcut-type="2" data-group-cls="btn-group-sm" data-off-active-cls="btn-warning" data-off-title="No" data-on-title="Yes" checked>
                                        </div>
                                        {{-- 
                                        <div class="col-md-3">
                                            <label for="chkELearning">E-learning: </label>
                                            <input id="chkELearning" name="chkELearning" type="checkbox" data-shortcut-type="7" data-group-cls="btn-group-sm" data-off-active-cls="btn-warning" data-off-title="No" data-on-title="Yes" checked>
                                        </div>
                                        --}}
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <!-- All filters -->
                                    <!-- Will be implemented in phase 2-->
                                    <!--
                                    Show Events:
                                    <input name="chkJoinDate" type="checkbox" value="true" checked> <label for="chkJoinDate">Join Date</label>
                                    <input name="chkProbationEnd" type="checkbox" value="true" checked> <label for="chkProbationEnd">Probation End</label>
                                    <input name="chkPositions" type="checkbox" value="true" checked> <label for="chkPositions">Positions</label>
                                    <input name="chkDepartments" type="checkbox" value="true" checked> <label for="chkDepartments">Departments</label>
                                    <input name="chkTransfer" type="checkbox" value="true" checked> <label for="chkTransfer">Transfers</label>
                                    <input name="chkDisciplinary" type="checkbox" value="true" checked> <label for="chkDisciplinary">Disciplinary</label>
                                    <input name="chkRewards" type="checkbox" value="true" checked> <label for="chkRewards">Rewards</label>
                                    <input name="chkAppraisal" type="checkbox" value="true" checked> <label for="chkAppraisal">Appraisal</label>
                                    <input name="chkQualifications" type="checkbox" value="true" checked> <label for="chkQualifications">Qualifications</label>
                                    <input name="chkTermination" type="checkbox" value="true" checked> <label for="chkTermination">Termination</label>
                                    -->
                                    <ul class="timeline">
                                        <?php if (isset($timelines)&& count($timelines)>0): ?>
                                        <?php $displayonLeft = true; ?>
                                        @foreach($timelines as $timeline)
                                            @if ($displayonLeft)
                                                <li data-shortcut-type="{{$timeline->ShortcutType}}">
                                                    <div class="timeline-badge {{$timeline->MainClass or 'danger'}}"><i class="{{$timeline->icon or 'fa fa-check'}}"></i>
                                                    </div>
                                                    <div class="timeline-panel">
                                                        <div class="timeline-heading">
                                                            <h4 class="timeline-title">{{ $timeline->EventType }}</h4>
                                                        </div>
                                                        <div class="timeline-body">
                                                            <p>{{ $timeline->Description }}</p>
                                                            @if (isset($timeline->formattedDate))
                                                                <p>{{ $timeline->formattedDate }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php $displayonLeft = false; ?>
                                            @else
                                                <li class="timeline-inverted" data-shortcut-type="{{$timeline->ShortcutType}}">
                                                    <div class="timeline-badge {{$timeline->MainClass or 'danger'}}"><i class="{{$timeline->icon or 'fa fa-check'}}"></i>
                                                    </div>
                                                    <div class="timeline-panel">
                                                        <div class="timeline-heading">
                                                            <h4 class="timeline-title">{{$timeline->EventType}}</h4>
                                                        </div>
                                                        <div class="timeline-body">
                                                            <p>{{ $timeline->Description }}</p>
                                                            @if (isset($timeline->formattedDate))
                                                                <p>{{ $timeline->formattedDate }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php $displayonLeft = true; ?>
                                            @endif

                                        @endforeach
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('post-body')
<link rel="stylesheet" href="{{URL::to('/')}}/css/lifecycle.css">
<link rel="stylesheet" href="{{URL::to('/')}}/css/timeline.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(function(){
        $(':checkbox').change(function() {
            var that = $(this);
            var shortcutType = that.attr('data-shortcut-type');
            if (that.prop('checked')) $("li[data-shortcut-type='" + shortcutType +"']").show();
            else $("li[data-shortcut-type='" + shortcutType +"']").hide();
        });
    })
</script>
@endsection
@extends('portal-index')
@section('title','Training Sessions')
@section('subtitle')
Training Sessions are for <strong class="text-danger">non-public</strong> courses only
@endsection
@section('content')
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($courseTrainingSessions) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    @if($allowedActions->contains('Create'))
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                    @endif
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($courseTrainingSessions) == 0)
                <h4 class="text-center">Its a bit empty here. 
                @if($allowedActions->contains('Create'))
                You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new course training session
                @endif
                </h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                            <th data-sortable="true">Name</th>
                            <th data-sortable="true">Course</th>
                            <th data-sortable="true">Is Final</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courseTrainingSessions as $courseTrainingSession)
                        <tr id="tr{{$courseTrainingSession->id}}">
                            <td>{{ $courseTrainingSession->name }}</td>
                            <td>{{ optional($courseTrainingSession->course)->description }}</td>
                            <td>{!! ($courseTrainingSession->is_final) ? '<span class="badge badge-info">Yes</span>' : '<span class="badge badge-default">No</span>' !!}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    @if($allowedActions->contains('Write'))
                                    <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$courseTrainingSession->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                    @endif
                                    @if($allowedActions->contains('Delete'))
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$courseTrainingSession->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $courseTrainingSessions->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'course_training_sessions.destroy'])
            @endcomponent
        </div>
    </div>
@endsection
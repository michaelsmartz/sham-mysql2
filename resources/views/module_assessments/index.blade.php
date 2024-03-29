@extends('portal-index')
@section('title','Module Assessments')
@section('content')
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($moduleAssessments) > 0)
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
            @if(count($moduleAssessments) == 0)
                <h4 class="text-center">Its a bit empty here.
                @if($allowedActions->contains('Create'))
                        You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new module assessment
                @endif
                </h4>
            @elseif($allowedActions->contains('List'))
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                            <th data-sortable="true">Description</th>
                            <th data-sortable="true">Module</th>
                            <th data-sortable="true">Assessment Type</th>
                            <th data-sortable="true">Pass Mark</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($moduleAssessments as $moduleAssessment)
                        <tr id="tr{{$moduleAssessment->id}}">
                            <td>{{ $moduleAssessment->description }}</td>
                            <td>{{ optional($moduleAssessment->module)->description }}</td>
                            <td>{{ optional($moduleAssessment->assessmentType)->description }}</td>
                            <td>{{ $moduleAssessment->pass_mark }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    @if($allowedActions->contains('Write'))
                                    <button type="button" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editFullPage('{{$moduleAssessment->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </button>
                                    @endif
                                    <button type="button" data-wenk="Review Candidate Responses" class="b-n b-n-r bg-transparent item-review" onclick="showResponses('{{$moduleAssessment->id}}', event)">
                                        <i class="glyphicon glyphicon-equalizer text-primary"></i>
                                    </button>
                                    @if($allowedActions->contains('Delete'))
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$moduleAssessment->id}}')">
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
                    {!! $moduleAssessments->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'module_assessments.destroy'])
            @endcomponent
        </div>
    </div>
@endsection
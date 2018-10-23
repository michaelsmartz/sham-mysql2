@extends('portal-index')
@section('title','Module Assessment Responses')
@section('right-title')
    <a href="{{route('module_assessments.index') }}" class="btn btn-default pull-right" title="Show all Module Assessments">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
@endsection
@section('content')
    <div class="flex-wrapper">
        <div id="table-container">
            <div class="table-responsive">
            @if(count($moduleAssessmentResponses) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new module assessment response</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                            <th data-sortable="true">Candidate</th>
                            <th data-sortable="true">Date Completed</th>
                            <th data-sortable="true">Reviewed</th>
                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($moduleAssessmentResponses as $moduleAssessmentResponse)
                        <tr id="tr{{$moduleAssessmentResponse->id}}">
                            <td>{{ optional($moduleAssessmentResponse->employee)->full_name }}</td>
                            <td>{{ $moduleAssessmentResponse->date_completed }}</td>
                            <td>{!! ($moduleAssessmentResponse->is_reviewed) ? '<span class="badge badge-info">Yes</span>' : '<span class="badge badge-default">No</span>'  !!}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editFullPage('{{$moduleAssessmentResponse->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $moduleAssessmentResponses->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> ''])
            @endcomponent
        </div>
    </div>
@endsection
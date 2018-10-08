@extends('portal-index')
@section('title','Module Assessments')
@section('content')
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($moduleAssessments) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom" onclick="addForm(event)">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($moduleAssessments) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new module assessment</h4>
            @else
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
                                    <button type="button" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editFullPage('{{$moduleAssessment->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </button>
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$moduleAssessment->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
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
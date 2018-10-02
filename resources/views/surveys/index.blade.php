@extends('portal-index')
@section('title','Surveys')
@section('content')
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($surveys) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom" onclick="addForm(event)">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($surveys) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new survey</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                            <th data-sortable="true">Title</th>
                            <th data-sortable="true">Status</th>
                            <th data-sortable="true">Author</th>
                            <th data-sortable="true">Start Date</th>
                            <th data-sortable="true">End Date</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($surveys as $survey)
                        <tr id="tr{{$survey->id}}">
                            <td>{{ $survey->title }}</td>
                            <td>{{ App\Enums\SurveyStatusType::getDescription($survey->survey_status_id) }}</td>
                            <td>{{ (isset($survey->users->employee->surname) && isset($survey->users->employee->first_name)) ? $survey->users->employee->surname." ".$survey->users->employee->first_name : '' }}</td>
                            <td>{{ $survey->date_start }}</td>
                            <td>{{ $survey->EndDate }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$survey->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                    <button type="button" class="b-n b-n-r bg-transparent item-results" data-wenk="Results" onclick="generateResult('{{$survey->id}}', event)">
                                        <i class="glyphicon glyphicon-th-list text-primary"></i>
                                    </button>
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$survey->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $surveys->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'surveys.destroy'])
            @endcomponent
        </div>
    </div>
@endsection
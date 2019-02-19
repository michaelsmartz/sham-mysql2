@extends('portal-index')
@section('title','Recruitment Requests')
@section('content')
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($requests) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom" onclick="addForm(event)">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($requests) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new recruitment request</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                            <th data-sortable="true">Job Title</th>
                            <th data-sortable="true">Year Experience</th>
                            <th data-sortable="true">Field Of Study</th>
                            <th data-sortable="true">Start Date</th>
                            <th data-sortable="true">Min Salary</th>
                            <th data-sortable="true">Max Salary</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                        <tr id="tr{{$request->id}}">
                            <td>{{ $request->job_title }}</td>
                            <td>{{ $request->year_experience }}</td>
                            <td>{{ $request->field_of_study }}</td>
                            <td>{{ $request->start_date }}</td>
                            <td>{{ $request->min_salary }}</td>
                            <td>{{ $request->max_salary }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editFullPage('{{$request->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                    <button class="b-n b-n-r bg-transparent item-view" data-wenk="View stages" onclick="pipelines('{{$request->id}}')">
                                        <i class="glyphicon glyphicon-eye-open text-primary"></i>
                                    </button>
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$request->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $requests->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'recruitment_requests.destroy'])
            @endcomponent
        </div>
    </div>
@endsection
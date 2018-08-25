@extends('portal-index')
@section('title','Employees')
@section('content')
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($employees) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom" onclick="addForm(event)">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($employees) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a to add a new employee</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                                                        <th data-sortable="true">Id</th>
                            <th data-sortable="true">First Name</th>
                            <th data-sortable="true">Surname</th>
                            <th data-sortable="true">Department</th>
                            <th data-sortable="true">Job Title</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                        <tr id="tr{{$employee->id}}">
                                                        <td>{{ $employee->id }}</td>
                            <td>{{ $employee->first_name }}</td>
                            <td>{{ $employee->surname }}</td>
                            <td>{{  isset($employee->department->description) ? $employee->department->description : ''  }}</td>
                            <td>{{  isset($employee->jobTitle->description) ? $employee->jobTitle->description : ''  }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <button data-wenk="Edit" type="button" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$employee->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </button>
                                    <button type="submit" class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$employee->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $employees->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'employees.destroy'])
            @endcomponent
        </div>
    </div>
@endsection
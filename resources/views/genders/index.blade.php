@extends('portal-index')
@section('title','Genders')
@section('content')
    <br>
    <ul class="nav nav-tabs">
        <li><a href="{{URL::to('/')}}/branches">Branch</a></li>
        <li><a href="{{URL::to('/')}}/countries">Country</a></li>
        <li><a href="{{URL::to('/')}}/departments">Department</a></li>
        <li><a href="{{URL::to('/')}}/divisions">Division</a></li>
        <li><a href="{{URL::to('/')}}/employeeattachmenttypes">Employee Attachment Types</a></li>
        <li><a href="{{URL::to('/')}}/employee_statuses">Employee Status</a></li>
        <li><a href="{{URL::to('/')}}/ethnic_groups">Ethnic Group</a></li>
        <li class="active"><a href="#">Gender</a></li>
        <li><a href="{{URL::to('/')}}/immigration_statuses">Immigration Status</a></li>
        <li><a href="{{URL::to('/')}}/job_titles">Job Title</a></li>
        <li><a href="{{URL::to('/')}}/languages">Language</a></li>
        <li><a href="{{URL::to('/')}}/marital_statuses">Marital Status</a></li>
        <li><a href="{{URL::to('/')}}/products">Products </a></li>
        <li><a href="{{URL::to('/')}}/skills">Skills</a></li>
        <li><a href="{{URL::to('/')}}/tax_statuses">Tax Status</a></li>
        <li><a href="{{URL::to('/')}}/teams">Team</a></li>
        <li><a href="{{URL::to('/')}}/time_groups">Time Group</a></li>
        <li><a href="{{URL::to('/')}}/time_periods">Time Periods</a></li>
        <li><a href="{{URL::to('/')}}/titles">Title</a></li>
    </ul>
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($genders) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom" onclick="addForm(event)">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($genders) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new gender</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                                                        <th data-sortable="true">Description</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($genders as $gender)
                        <tr id="tr{{$gender->id}}">
                                                        <td>{{ $gender->description }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$gender->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$gender->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $genders->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'genders.destroy'])
            @endcomponent
        </div>
    </div>
@endsection
@extends('portal-index')
@section('title','Languages')
@section('subtitle','Language drop-down values for employees')
@section('content')
    <br>
    <ul class="nav nav-tabs">
        <li><a href="{{URL::to('/')}}/branches">Branch</a></li>
        <li><a href="{{URL::to('/')}}/countries">Country</a></li>
        <li><a href="{{URL::to('/')}}/departments">Department</a></li>
        <li><a href="{{URL::to('/')}}/divisions">Division</a></li>
        <li><a href="{{URL::to('/')}}/employee_attachment_types">Employee Attachment Types</a></li>
        <li><a href="{{URL::to('/')}}/employee_statuses">Employee Status</a></li>
        <li><a href="{{URL::to('/')}}/ethnic_groups">Ethnic Group</a></li>
        <li><a href="{{URL::to('/')}}/genders">Gender</a></li>
        <li><a href="{{URL::to('/')}}/immigration_statuses">Immigration Status</a></li>
        <li><a href="{{URL::to('/')}}/job_titles">Job Title</a></li>
        <li class="active"><a href="#">Language</a></li>
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
            @if(count($languages) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($languages) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new language</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                                                        <th data-sortable="true">Description</th>
                            <th data-sortable="true">Preferred</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($languages as $language)
                        <tr id="tr{{$language->id}}">
                                                        <td>{{ $language->description }}</td>
                            <td>{{ ($language->is_preferred) ? 'Yes' : 'No' }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$language->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$language->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $languages->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'languages.destroy'])
            @endcomponent
        </div>
    </div>
@endsection
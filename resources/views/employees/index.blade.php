@extends('portal-index')

@section('title','Employees')
@section('subtitle','Add, edit and remove employees of your company')
@section('content')
    <div class="flex-wrapper">
        @if($allowedActions->contains('List'))
        <div id="filter-sidebar" class="card shadow-eff1 sidebar-nav" role="navigation" style="height:170px">
            <form action="" class="">
                <ul style="margin-left:0;padding-left:0" class="list-unstyled">
                    <li>
                        <input type="hidden" name="name" class="submitable-column-name" id="submitable-column-name" value="">
                        <div class="table-search-form">
                            <input type="search" name="search-term" value="{{old('search-term', null)}}" placeholder="Search" class="search-input" data-mirror="#submitable-column-name">
                            <div class="search-option">
                                <button type="submit" data-wenk="Do the Search">
                                    <i class="fa fa-search"></i>
                                </button>
                                <a href="{{route('employees.index')}}" role="button" data-wenk="Reset all Criteria & reload the list">
                                    <i class="fa fa-refresh"></i>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="table-search-form" style="height:50px">
                            <button type="button" class="search-column-chooser-btn">
                                <p class="search-small">Search by</p>
                                <p class="search-large">Name</p>
                            </button>
                        </div>
                        <ul class="search-column-list">
                            <li data-filter-column="name">By Name <i class="fa fa-question-circle" data-wenk="Search on First Name/Surname"></i></li>
                            <li data-filter-column="department:description">By Department</li>
                            <li data-filter-column="jobtitle:description">By Job Title</li>
                        </ul>
                    </li>
                </ul>
            </form>
        </div>
        @endif
        <div id="table-container">
            @if(count($employees) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    @if($allowedActions->contains('List'))
                    <button id="sidebarCollapse" class="btn btn-default" data-toggle="offcanvas">
                        <i class="glyphicon glyphicon-align-left"></i> 
                        <span>Filters</span>
                    </button>
                    @endif
                    @if($allowedActions->contains('Create'))
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                    @endif
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($employees) == 0)
                <h4 class="text-center">Its a bit empty here. 
                @if($allowedActions->contains('Create'))
                You may click <a href="javascript:;" class="text-primary item-create">here</a to add a new employee
                @endif
                </h4>
            @elseif($allowedActions->contains('List'))
                <table id="table" data-toggle="table" data-detail-view="true">
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
                        <tr id="tr{{$employee->id}}" data-id="{{$employee->id}}" data-url="{{url()->current()}}">
                            <td>{{ $employee->id }}</td>
                            <td>{{ $employee->first_name }}</td>
                            <td>{{ $employee->surname }}</td>
                            <td>{{ optional($employee)->department }}</td>
                            <td>{{ optional($employee)->job_title }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                 @if($allowedActions->contains('Write'))
                                    <button type="button" class="b-n b-n-r bg-transparent item-edit" data-wenk="Edit" onclick="editFullPage('{{$employee->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </button>
                                @endif
                                    <button type="button" class="b-n b-n-r bg-transparent" data-wenk="Show Timeline" onclick="showTimeline('{{$employee->id}}', event)">
                                        <i class="glyphicon glyphicon-film text-primary"></i>
                                    </button>
                                @if($allowedActions->contains('Delete'))
                                    <button type="button" class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$employee->id}}')">
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
                    {!! $employees->appends(request()->query())->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'employees.destroy'])
            @endcomponent
        </div>
    </div>
@endsection

@section('post-body')
    <script>
        $(function(){
            $(':input[data-mirror]').each(function () {
                $(this).mirror($(this).data('mirror'));
            });
        });
    </script>
@endsection
@extends('portal-index')
@section('title','Surveys')
@section('subtitle', 'Address surveys to all or specific employees')

@section('content')
    <div class="flex-wrapper">
        @if($allowedActions->contains('List'))
            <div id="filter-sidebar" class="card shadow-eff1 sidebar-nav" role="navigation">
                <form action="" class="">
                    <ul style="margin-left:0;padding-left:0" class="list-unstyled">
                        <li>
                            <input type="hidden" name="title" class="submitable-column-name" id="submitable-column-name" value="">
                            <div class="table-search-form">
                                <input type="search" name="search-term" value="{{old('search-term', null)}}" placeholder="Search" class="search-input" data-mirror="#submitable-column-name">
                                <div class="search-option">
                                    <button type="submit" data-wenk="Do the Search">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <a href="{{route('surveys.index')}}" role="button" data-wenk="Reset all Criteria & reload the list">
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="table-search-form" style="height:50px">
                                <button type="button" class="search-column-chooser-btn">
                                    <p class="search-small">Search by</p>
                                    <p class="search-large">Title</p>
                                </button>
                            </div>
                            <ul class="search-column-list">
                                <li data-filter-column="title">By Title</li>
                            </ul>
                        </li>
                    </ul>
                </form>
            </div>
        @endif
        <div id="table-container">
            @if(count($surveys) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    @if($allowedActions->contains('List'))
                        <button id="sidebarCollapse" class="btn btn-default" data-toggle="offcanvas">
                            <i class="glyphicon glyphicon-align-left"></i>
                            <span>Filters</span>
                        </button>
                    @endif
                    @if($allowedActions->contains('Create'))
                        <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="right">
                            <i class="glyphicon glyphicon-plus"></i> <strong>Add New</strong>
                        </button>
                    @endif
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($surveys) == 0)
                <h4 class="text-center">Its a bit empty here.
                    @if($allowedActions->contains('Create'))
                        You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new survey
                    @endif
                </h4>
            @elseif($allowedActions->contains('List'))
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                            <th data-sortable="true">Title</th>
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
                            <td>{{ (isset($survey->users->employee->full_name)) ? $survey->users->employee->full_name : '' }}</td>
                            <td>{{ $survey->date_start }}</td>
                            <td>{{ $survey->date_end }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <button type="button" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$survey->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </button>
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
            @component('partials.index', ['routeName'=> 'surveys.destroy', 'fullPageEdit'=>true])
            @endcomponent
        </div>
    </div>
@endsection
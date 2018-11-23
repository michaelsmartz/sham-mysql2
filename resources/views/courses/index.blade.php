@extends('portal-index')
@section('title','Courses')
@section('content')
    <div class="flex-wrapper">
        @if($allowedActions->contains('List'))
        <div id="filter-sidebar" class="card shadow-eff1 sidebar-nav" role="navigation">
            <form action="" class="">
                <ul style="margin-left:0;padding-left:0" class="list-unstyled">
                    <li>
                        <input type="hidden" name="description" class="submitable-column-name" id="submitable-column-name" value="">
                        <div class="table-search-form">
                            <input type="search" name="search-term" value="{{old('search-term', null)}}" placeholder="Search" class="search-input" data-mirror="#submitable-column-name">
                            <div class="search-option">
                                <button type="submit" data-wenk="Do the Search">
                                    <i class="fa fa-search"></i>
                                </button>
                                <a href="{{route('courses.index')}}" role="button" data-wenk="Reset all Criteria & reload the list">
                                    <i class="fa fa-refresh"></i>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="table-search-form" style="height:50px">
                            <button type="button" class="search-column-chooser-btn">
                                <p class="search-small">Search by</p>
                                <p class="search-large">Description</p>
                            </button>
                        </div>
                        <ul class="search-column-list">
                            <li data-filter-column="description">By Description</li>
                        </ul>
                    </li>
                    <hr>
                    <li>
                        <ul class="nav">
                            <li><p class="menu-label">Quick Filters</p></li>
                            <li><a href="{{route('courses.index')}}?is_public=1"><span class="icon circle info"></span>Public</a></li>
                            <li><a href="{{route('courses.index')}}?is_public=0"><span class="icon circle default"></span>Private</a></li>
                        </ul>
                    </li>
                </ul>
            </form>
        </div>
        @endif
        <div id="table-container">
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
            <div class="table-responsive">
                @if(count($courses) == 0)
                    <h4 class="text-center">Its a bit empty here. 
                    @if($allowedActions->contains('Create'))
                        You may click <a href="javascript:;" class="text-primary item-create">here</a to add a new Course
                    @endif
                    </h4>
                @elseif($allowedActions->contains('List'))
                    <table id="new-table" data-toggle="table">
                        <thead>
                            <tr>
                                <th data-sortable="true">Description</th>
                                <th data-sortable="true">Public</th>
                                <th data-sortable="false" data-tableexport-display="none">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($courses as $course)
                            <tr id="tr{{$course->id}}">
                                <td>{{ $course->description }}</td>
                                <td>{!! ($course->is_public) ? '<span class="badge badge-info">Yes</span>' : '<span class="badge badge-default">No</span>' !!}</td>
                                <td data-html2canvas-ignore="true">
                                    <!--
                                    <div class="dropdown">
                                        <a href="#" data-toggle="dropdown"><i class="fa fa-ellipsis-v text-grey-light"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item text-primary" href="javascript:;"  onclick="editForm('{{$course->id}}')">
                                            <i class="fa fa-fw fa-edit"></i> Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" href="javascript:;" onclick="deleteForm('{{$course->id}}')">
                                            <i class="fa fa-fw fa-trash"></i> Delete</a>
                                        </div>
                                    </div>
                                    -->
                                    <div class="btn-group btn-group-xs" role="group">
                                        @if($allowedActions->contains('Write'))
                                        <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$course->id}}', event)">
                                            <i class="glyphicon glyphicon-edit text-primary"></i>
                                        </a>
                                        @endif
                                        @if($allowedActions->contains('Delete'))
                                        <button type="submit" class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$course->id}}')">
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
                        {!! $courses->render() !!}
                    </nav>
                @endif
            </div>
            @component('partials.index', ['routeName'=> 'courses.destroy'])
            @endcomponent
        </div>
    </div>

@endsection
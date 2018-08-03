@extends('portal-index')
@section('title','Courses')
@section('content')
    <div class="flex-wrapper">
        <div id="filter-sidebar" class="card shadow-eff1 sidebar-nav" role="navigation">
            <form action="" class="table-search-form">
                <input type="search" value="" placeholder="Search" class="search-input">
                <div class="search-option">
                    <button type="reset" data-wenk="Reset all Criteria & reload the list" data-tootik-conf="left">
                        <i class="fa fa-refresh"></i>
                    </button>
                </div>
            </form>
            <ul class="nav">
                <li><p class="menu-label">Quick Filters</p></li>
                <li><a href="{{route('courses.index')}}?is_public=1"><span class="icon circle info"></span>Public</a></li>
                <li><a href="{{route('courses.index')}}?is_public=0"><span class="icon circle default"></span>Private</a></li>
                <li><a href="{{route('courses.index')}}"><span class="icon circle"></span>Unfiltered</a></li>
            </ul>
        </div>
        <div id="table-container">
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="right" onclick="addForm(event)">
                        <i class="glyphicon glyphicon-plus"></i> <strong>Add New</strong>
                    </button>
                    <button id="sidebarCollapse" class="btn btn-default" data-toggle="offcanvas">
                        <i class="glyphicon glyphicon-align-left"></i> 
                        <span>Filters</span>
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                @if(count($courses) == 0)
                    <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a to add a new Course</h4>
                @else
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
                                        <button data-wenk="Edit" type="button" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$course->id}}', event)">
                                            <i class="glyphicon glyphicon-edit text-primary"></i>
                                        </button>

                                        <button type="submit" class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$course->id}}')">
                                            <i class="glyphicon glyphicon-remove text-danger"></i>
                                        </button>
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
@section('post-body')
    
@endsection
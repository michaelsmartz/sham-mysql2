@extends('portal-index')
@section('title','Recruitment Requests')
@section('content')
    <div class="flex-wrapper">
        <div id="filter-sidebar" class="card shadow-eff1 sidebar-nav" role="navigation">
            <form action="" class="">
                <ul style="margin-left:0;padding-left:0" class="list-unstyled">
                    <li>
                        <input type="hidden" name="job_title" class="submitable-column-name" id="submitable-column-name" value="">
                        <div class="table-search-form">
                            <input type="search" name="search-term" value="{{old('search-term', null)}}" placeholder="Search" class="search-input" data-mirror="#submitable-column-name">
                            <div class="search-option">
                                <button type="submit" data-wenk="Do the Search">
                                    <i class="fa fa-search"></i>
                                </button>
                                <a href="{{route('recruitment_requests.index')}}" role="button" data-wenk="Reset all Criteria & reload the list">
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
                            <li data-filter-column="job_title">By Job Title</li>
                            <li data-filter-column="qualification_recruitment:description">By Highest Qualification</li>
                            <li data-filter-column="year_experience">By Year Experience</li>
                            <li data-filter-column="field_of_study">By Field Of Study</li>
                            <li data-filter-column="start_date">By Start Date</li>
                        </ul>
                    </li>
                    <br>
                    <li>
                        <ul class="nav">
                            <li><p class="menu-label">Quick Filters</p></li>
                            <li style="line-height: 0px;">
                                <a href="{{route('recruitment_requests.index')}}?is_approved=1"><span class="icon circle info"></span>Approved</a>
                                <a href="{{route('recruitment_requests.index')}}?is_approved=0"><span class="icon circle default"></span>Declined</a>

                                <a href="{{route('recruitment_requests.index')}}?is_completed=1"><span class="icon circle info"></span>Completed</a>
                                <a href="{{route('recruitment_requests.index')}}?is_completed=0"><span class="icon circle default"></span>Not Completed</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </form>
        </div>
        <div id="table-container">
            @if(count($requests) > 0)
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
            @if(count($requests) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new recruitment request</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                            <th data-sortable="true">Job Title</th>
                            <th data-sortable="true">Date Period</th>
                            <th data-sortable="true">Approved</th>
                            <th data-sortable="true">Completed</th>
                            <th data-sortable="true">Positions</th>
                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                        <tr id="tr{{$request->id}}">
                            <td>{{ $request->job_title }}</td>
                            <td>{{ $request->start_date }} <strong>to</strong> {{ $request->end_date }}</td>
                            <td>{!! ($request->is_approved) ? '<span class="badge badge-info">Yes</span>' : '<span class="badge badge-default">No</span>' !!}</td>
                            <td>{!! ($request->is_completed) ? '<span class="badge badge-info">Yes</span>' : '<span class="badge badge-default">No</span>' !!}</td>
                            <td>{{ $request->quantity }}</td>
                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <button class="b-n b-n-r bg-transparent item-edit" data-wenk="Edit" onclick="editFullPage('{{$request->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </button>
                                    <?php if($request->is_approved){ ?>
                                    <a href="#light-modal" data-wenk="Manage Candidates" class="b-n b-n-r bg-transparent item-edit" onclick="manageCandidate('{{$request->id}}', event)">
                                        <i class="glyphicon glyphicon-list-alt text-primary"></i>
                                    </a>
                                    <button class="b-n b-n-r bg-transparent item-view" data-wenk="View stages" onclick="pipelines('{{$request->id}}')">
                                        <i class="glyphicon glyphicon-arrow-right text-primary"></i>
                                    </button>
                                    <?php } ?>
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
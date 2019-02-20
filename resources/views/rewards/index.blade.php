@extends('portal-index')
@section('title','Timeline')
@section('subtitle', 'All employees milestones in one place')
@section('right-title')
    <a href="{{route('employees.index') }}" class="btn btn-default pull-right" title="Show all Employees">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
@endsection
@section('content')
     {{ AsyncWidget::run('timeline_header', ['employee' => $id]) }}
    <ul class="nav nav-tabs">
        <li><a href="{{URL::to('timelines')}}/{{ $id }}">Timeline</a></li>
        <li class="active"><a href="{{URL::to('rewards')}}{{'/employee/'}}{{ $id }}">Rewards</a></li>
        <li><a href="{{URL::to('disciplinaryactions')}}{{'/employee/'}}{{ $id }}">Disciplinary Actions</a></li>
    </ul>
    <br>
    <div class="flex-wrapper">
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
                                <a href="{{URL::to('rewards')}}{{'/employee/'}}{{ $id }}" role="button" data-wenk="Reset all Criteria & reload the list">
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
                            <li data-filter-column="description">By Description</li>
                            <li data-filter-column="rewarded_by">By Rewarded By</li>
                            <li data-filter-column="date_received">By Date Received</li>
                        </ul>
                    </li>
                </ul>
            </form>
        </div>
        <div id="table-container">
            @if(count($rewards) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-create-url="{{action('RewardsController@create',['employee' => $id])}}" data-wenk="Add new" data-wenk-pos="bottom">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($rewards) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create" data-create-url="{{action('RewardsController@create',['employee' => $id])}}">here</a> to add a new reward</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                            <th data-sortable="true">Description</th>
                            <th data-sortable="true">Rewarded By</th>
                            <th data-sortable="true">Date Received</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rewards as $reward)
                        <tr id="tr{{$reward->id}}">
                            <td>{{ $reward->description }}</td>
                            <td>{{ optional($reward)->rewarded_by }}</td>
                            <td>{{ $reward->date_received }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$reward->id}}', event, '{{\Route::currentRouteName()}}')">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$reward->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $rewards->appends(request()->query())->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'rewards.destroy'])
            @endcomponent
        </div>
    </div>
@endsection

@section('scripts')
<link rel="stylesheet" href="{{URL::to('/')}}/css/lifecycle.css">
@endsection